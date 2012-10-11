#!/usr/bin/perl -w

use strict;

use DBI;
use Image::ExifTool;
use Image::Magick;
use File::Basename;
use File::MimeInfo;
use List::Util qw(max min);
use Proc::Daemon;
use Sys::Syslog qw(:standard :macros);
use Date::Format;
use Date::Parse;

use constant PIDFILE		=> '/tmp/bubba-album.pid';
use constant THUMB_WIDTH	=> 100;
use constant THUMB_HEIGHT	=> 100;
use constant SCALE_WIDTH	=> 600;
use constant HDTV_WIDTH     => 1920;
use constant HDTV_HEIGHT    => 1080;
use constant CACHE_PATH		=> '/var/lib/album/thumbs';
use constant THUMB_PATH		=> CACHE_PATH . '/thumbs';
use constant SCALE_PATH		=> CACHE_PATH . '/rescaled';
use constant HDTV_PATH      => CACHE_PATH . '/hdtv';
use constant SPOOL_PATH     => '/var/spool/album';


unless( -d CACHE_PATH ) {
    mkdir CACHE_PATH;
}
unless( -d THUMB_PATH ) {
    mkdir THUMB_PATH;
}
unless( -d HDTV_PATH ) {
    mkdir HDTV_PATH;
}
unless( -d SCALE_PATH ) {
    mkdir SCALE_PATH;
}
unless( -d SPOOL_PATH ) {
    mkdir SPOOL_PATH;
}

my $daemon = Proc::Daemon->new(
    pid_file => PIDFILE,
    work_dir => '/'
);
exit if $daemon->Status(PIDFILE);

my $kid_pid = $daemon->Init;

if( $kid_pid ) {
    exit;
}

openlog("album-import", "", LOG_USER);
syslog(LOG_INFO, "Starting album import worker");

my $dbh;
{
    my $db = { do '/etc/album/debian-db.perl' };
    $dbh = DBI->connect(
        "dbi\:$db->{type}\:database=$db->{name};host=$db->{host};port=$db->{port}",
        $db->{user},
        $db->{pass},
        {
            RaiseError => 1,
            AutoCommit => 1
        }
    );
    $dbh->do("SET NAMES UTF8");
}
my $update_image_table = $dbh->prepare("UPDATE image SET name=?, caption=? WHERE id=?");
my $image_set_date = $dbh->prepare("UPDATE image SET created=? WHERE id=? AND created IS NULL");


LOOP: while(1) {
    if( opendir( my $spool, SPOOL_PATH ) ) {
        # Grab all current symlinks in the spool dir
        my %queue = map { $_ => readlink(SPOOL_PATH . '/' . $_) } grep { -l SPOOL_PATH . '/' . $_ } readdir( $spool );
        unless(scalar keys %queue) {
            syslog(LOG_INFO, "processing completed, shutting down");
            # we are done this time
            last LOOP;
        }
        while(my($id, $image) = each(%queue) ) {
            if($image) {
                syslog(LOG_INFO, "Processing image %s with id %d", $image, $id);
                my $info = process_exif($id, $image);
                process_thumb($id, $image, $info);
            }
            unlink(SPOOL_PATH . '/' . $id);
        }
        # Don't be too hasty here.
        closedir( $spool );
        sleep 10;
    }
}

sub process_exif {
    my( $id, $image ) = @_;

    my $exifTool = new Image::ExifTool();

    $exifTool->ExtractInfo( $image );

    my $info = $exifTool->GetInfo(
        'ImageWidth',
        'ImageHeight',
        'Title',
        'Subject',
        'DateTime'
    );

    my $title = $info->{Title} ? $info->{Title} : basename( $image );
    my $dt = time2str('%Y-%m-%d %X',  $info->{DateTime} ? str2time($info->{DateTime}) : 0 );

    $update_image_table->execute( $title, $info->{Subject}, $id);
    $image_set_date->execute($dt, $id);
    return $info;
}

sub process_thumb {
    my( $id, $image, $info ) = @_;

    my $mimetype = mimetype($image);

    if( $mimetype eq "image/png" ) {
        my $p = new Image::Magick;
        my $x;
        $x=$p->Read($image);
        unless( -f SCALE_PATH . "/$id") { 
            $x=$p->Thumbnail( geometry => SCALE_WIDTH."x" );
            $x=$p->Write(SCALE_PATH . "/$id");
        }
        unless( -f HDTV_PATH . "/$id") { 
            $x=$p->Thumbnail( geometry => HDTV_WIDTH."x".HDTV_HEIGHT.">" );
            $x=$p->Write(HDTV_PATH . "/$id");
        }
        unless( -f THUMB_PATH . "/$id") { 
            $x=$p->Set( Gravity => 'Center' );
            $x=$p->Thumbnail( geometry => THUMB_WIDTH.'x'.THUMB_HEIGHT.'^' );
            $x=$p->Set(background => 'transparent');
            $x=$p->Extent( geometry => THUMB_WIDTH.'x'.THUMB_HEIGHT );
            $x=$p->Write(THUMB_PATH . "/$id");
        }
    } elsif( $mimetype eq "image/jpg" || $mimetype eq "image/jpeg" ) {
        unless( -f THUMB_PATH . "/$id") { 
            system(
                "epeg",
                "-m",
                max( THUMB_HEIGHT, THUMB_WIDTH ) * 2,
                $image,
                THUMB_PATH . "/$id"
            );
        }

        unless( -f HDTV_PATH . "/$id") {
            my $maximum;
            if($info->{ImageWidth} > $info->{ImageHeight}) {
                $maximum = min(HDTV_WIDTH, $info->{ImageWidth});
            } else {
                $maximum = min(HDTV_HEIGHT, $info->{ImageHeight});
            }
            system(
                "epeg",
                '-m', $maximum,
                $image,
                HDTV_PATH . "/$id"
            );
        }

        unless( -f SCALE_PATH . "/$id") { 
            system(
                "epeg",
                "-m ".SCALE_WIDTH,
                $image,
                SCALE_PATH . "/$id"
            );
        }
    }
}

