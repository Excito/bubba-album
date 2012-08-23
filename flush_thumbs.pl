#!/usr/bin/perl -w

use strict;

use DBI;
use v5.10;



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

my $d = $dbh->selectall_hashref("SELECT path, id FROM image", 'id');
use Data::Dumper;

foreach my $image(values %$d) {
    symlink $image->{path}, "/var/spool/album/$image->{id}";
}

exec "/usr/sbin/album_import.pl";
