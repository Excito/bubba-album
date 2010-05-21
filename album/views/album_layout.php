<?='<?xml version="1.0" encoding="utf8"?>'?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Bubba|2 - photo album</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" type="text/css" href="<?=$this->config->item("base_url")?>/views/_css/jquery.ui.theme.default.css" />
<link rel="stylesheet" type="text/css" href="<?=$this->config->item("base_url")?>/views/_css/admin.css" />
<link rel="stylesheet" type="text/css" href="<?=$this->config->item("base_url")?>/views/_css/album.css" />
<link rel="stylesheet" type="text/css" href="<?=$this->config->item("base_url")?>/views/_css/jquery.ui.throbber.css" />

<script type="text/javascript" src="<?=$this->config->item("base_url")?>/views/_js/jquery.js"></script>
<script type="text/javascript" src="<?=$this->config->item("base_url")?>/views/_js/jquery-ui.js"></script>
<script type="text/javascript" src="<?=$this->config->item("base_url")?>/views/_js/jquery.ui.dialog.js"></script>
<script type="text/javascript" src="<?=$this->config->item("base_url")?>/views/_js/jquery.ui.throbber.js"></script>
<script type="text/javascript" src="<?=$this->config->item("base_url")?>/views/_js/jquery.validate.js"></script>


<script type="text/javascript" src="<?=$this->config->item("base_url")?>/views/_js/main.js"></script>

<!-- Internationalization -->
<script type="text/javascript" src="<?=$this->config->item("base_url")?>/views/_js/jquery.sprintf.js"></script>
<?global $langcode?>
<?if(file_exists(APPPATH."i18n/$langcode/messages.js")):?>
<script type="text/javascript" src="<?=$this->config->item("base_url")."/i18n/$langcode/messages.js"?>"></script>
<?else :?>
<script type="text/javascript" src="<?=$this->config->item("base_url")."/i18n/en/messages.js"?>"></script>
<?endif?>

<script>
config = <?=json_encode(
	array(
		'prefix' => site_url(),
		'userinfo' => $userinfo
)
)?>;
manager_mode = <?=json_encode((bool)$this->session->userdata('manager_mode'))?>;
</script>

<script>
jQuery.validator.setDefaults({ 
	errorPlacement: function(label, element) {
		label.insertAfter( element );
		label.position({
			'my': 'left bottom',
			'at': 'right center',
			'of': element,
			'offset': "-20 -20"
		});
	},
	invalidHandler: function() {
		$(this).closest('ui-dialog').children('.ui-dialog-buttonpane').find('.ui-button').button('enable');
	}	
});	
function postlogin_callback() {
	var self = this;
	var serial = $("#fn-login-dialog-form").serialize();
	$("#fn-login-dialog-button").attr('disabled','disabled');
	$("#fn-login-dialog-button").addClass("ui-state-disabled");
	$("#fn-login-error").children().hide();
	$.post(config.prefix+'/login/json',
	serial,
		function(data){
			if(data.authfail) {
				$("#fn-login-error-pwd").show();
				$("#password").select();
				$("#fn-login-dialog-button").removeAttr('disabled');
				$("#fn-login-dialog-button").removeClass("ui-state-disabled");
			} else {
				$(self).dialog('close');
				$(self).dialog('destroy');
				config.userinfo = data.userinfo;
				update_topnav_status();
				update_manager_mode();
				$.event.trigger('auth_changed');
			}
		},"json");
}
function postlogout_callback( event, ui ) {
	var self = this;
	$("#fn-logout-dialog-button").attr('disabled','disabled');
	$("#fn-logout-dialog-button").addClass("ui-state-disabled");
	$.post(
		config.prefix+'/logout/json',
		{},
		function(data){
			$(self).dialog('close');
			$(self).dialog('destroy');
			config.userinfo = data.userinfo;
			update_topnav_status();
			update_manager_mode();
			$.event.trigger('auth_changed');
		},"json"
	);
}

function update_topnav_status() {
	var topnav_status = $('#topnav_status');
	if( !config.userinfo ) {
		return;
	}
	if( config.userinfo.logged_in ) {
		if( config.userinfo.groups['bubba'] ) {
			topnav_status.html($.message("topnav-authorized-bubba", config.userinfo.realname));
		} else if(config.userinfo.groups['album']) {
			topnav_status.html($.message("topnav-authorized-album", config.userinfo.realname));
		} else {
			topnav_status.html($.message("topnav-authorized", config.userinfo.realname));
		}
	} else {
		topnav_status.html($.message("topnav-not-authorized"));
	}
}

function dialog_loginclose_callback() {
	$("#fn-login-error").children().hide();
}

function dialog_login(e) {
	var self = this;

	$.dialog(
		$("#div-login-dialog").show(),
		"",
		[
			{
				'label': $.message("login-dialog-continue"),
				'callback': postlogin_callback,
				options: { 'id': 'fn-login-dialog-button', 'class' : 'ui-element-width-100' }
			}
		],
		{
			dialogClass : "ui-login-dialog",
			draggable: false,
			close : dialog_loginclose_callback
		}
	);

return false;
}

function dialog_logout() {
	
	var buttons = [
        {
            'label': $.message("logout-dialog-button-logout"),
			'callback': postlogout_callback,
			options: { 'id': 'fn-logout-dialog-button', 'class' : 'ui-element-width-100' }
		}
	];
	$.confirm( 
			$.message("logout-dialog-message"),
			$.message("logout-dialog-title"),
			buttons
	);
}

$(function(){
	
	$('#fn-topnav-logout').click(function(event) {
		if( config.userinfo && config.userinfo.logged_in ) {
			dialog_logout();
		} else {
			dialog_login();
		}
	});
});
</script>
<?if($head):?>
<?=$head?>
<?endif?>
</head>
<body>
<div id="bg-right"></div>
<div id="wrapper" class="fn-page-<?=$this->uri->segment(2)?>">
    <table id="wrapper">	    
    
		<tr>
		<td id="topnav">
		<div id="topnav-content">
		<div id="topnav-content-inner">
				<span id="topnav_status">
	
			<?if ($userinfo['logged_in']): ?>
			<?if(isset($userinfo['groups']['bubba'])):?>
				<?=t("topnav-authorized-bubba",$userinfo['realname'])?>
			<?elseif(isset($userinfo['groups']['bubba'])):?>
	            <?=t("topnav-authorized-album",$userinfo['realname'])?>
			<?else :?>
	            <?=t("topnav-authorized",$userinfo['realname'])?>
			<?endif?>
			<?else :?>
	            <?=t("topnav-not-authorized")?>
			<?endif?>
        </span>
            <button id="fn-topnav-logout" class="ui-button" role="button" aria-disabled="false"><div class="ui-icons ui-icon-logout"></div><div id="s-topnav-logout" class="ui-button-text"><?=t("topnav-logout")?></div></button>
            <button id="fn-topnav-home" class="ui-button" role="button" aria-disabled="false"><div class="ui-icons ui-icon-home"></div><div id="s-topnav-home" class="ui-button-text"><?=t("topnav-home")?></div></button>
            <!--button id="fn-topnav-settings" class="ui-button" role="button" aria-disabled="false"><div class="ui-icons ui-icon-settings"></div><div id="s-topnav-settings" class="ui-button-text"><?=t("topnav-settings")?></div></button-->
            <button id="fn-topnav-help" class="ui-button" role="button" aria-disabled="false"><div class="ui-icons ui-icon-help"></div><div id="s-topnav-help" class="ui-button-text"><?=t("topnav-help")?></div></button>
		</div>
		</div>
		</td> 	<!-- topnav --> 
		<td id="empty-header"></td>
        </tr>   
    
		<tr>
		<td id="content_wrapper">	
            <div id="header">		
                
				<a href="#" id="a_logo" onclick="location.href='<?=$this->config->item("base_url")?>';"><img id="img_logo" src="<?=$this->config->item("base_url").'/views'?>/_img/logo.png" alt="BUBBA | 2" title="BUBBA | 2" /></a>

            </div>	<!-- header -->		
            <div id="content">
				<?=$content_for_layout?>
            </div>	<!-- content -->
            
    		<div id="update_status" class="ui-corner-all ui-state-highlight ui-helper-hidden"></div>
        </td>	<!-- content_wrapper -->

		</tr>
	</table> <!-- wrapper -->

<div id="layout-templates" class="ui-helper-hidden">

<div id="div-login-dialog">
<form method="post" class="ui-form-login-dialog" id="fn-login-dialog-form">
	<h2 class="ui-text-center"><?=t('login-dialog-header')?></h2>
	<table>
		<tr>
			<td>
				<label for="username"><?=t("Username")?>:</label><br>
				<input
					type="text" 
					name="username"
					class="ui-input-text"
				/>
			</td>
		</tr>
		<tr>
			<td>
				<label for="password"><?=t("Password")?>:</label><br>
				<input
					type="password" 
					name="password"
					class="ui-input-text"
				/>
			</td>
		</tr>
	</table>
	<div id="fn-login-error">
		<div id="fn-login-error-pwd" class="ui-state-error-text ui-helper-hidden ui-login-dialog-error ui-text-center">
			<?=t('login-error-pwd')?>
		</div>
	</div>
</form>
</div>

</div>
</body>
</html>
