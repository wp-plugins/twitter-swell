<?php
/*
Plugin Name: Twitter Swell
Plugin URI: http://icyleaf.com
Description: 添加Twiiter信息输入框到自己的博客上面并个性化输出显示。(You coult post message to your Twitter and show it.)
Version: 0.8.1
Author: icyleaf
Author URI: http://icyleaf.com
*/

// Support l10n
if(function_exists('load_plugin_textdomain')) {
	load_plugin_textdomain('ws-twitter-swell', $path = 'wp-content/plugins/twitter-swell/languages');
}

// Add to Admin Menu
function WSTS_AdminMenu(){
    add_submenu_page('options-general.php', 'Twitter Swell', 'Twitter Swell', 10, __FILE__, 'WSTS_Function');
}

// Main Function
function WSTS_Function(){
	echo '<div class="wrap"><h2>'.__('Twitter Swell设置', 'ws-twitter-swell').'</h2>';

	$WSTSUser = get_option("WSTS_User");
	$WSTSPwd = get_option("WSTS_Pwd");
	$WSTSMsgCount = get_option("WSTS_MessageCount");
	if($WSTSMsgCount==""){
		$WSTSMsgCount = 1;
	}

	if(!empty($_POST['wsts_do'])) {
		switch($_POST['wsts_do']) {
			case __('保存设置', 'ws-twitter-swell'):
				// set vars
				$WSTSUser = $_POST['WSTSuser'];
				$WSTSPwd = $_POST['WSTSPwd'];
				$WSTSMsgCount = $_POST['WSTSMsgCount'];
				$WSTSAddonsWordsFlag = $_POST['WSTSAddonsWordsFlag'];
				update_option("WSTS_User", $WSTSUser);
				update_option("WSTS_Pwd", $WSTSPwd);
				update_option("WSTS_MessageCount", $WSTSMsgCount);
				update_option("WSTS_AddonsWordsFlag", $WSTSAddonsWordsFlag);
				break;
			case __('删除本插件', 'ws-twitter-swell'):
				delete_option("WSTS_User");
				delete_option("WSTS_Pwd");
				delete_option("WSTS_MessageCount");
				delete_option("WSTS_AddonsWordsFlag");
				echo "<center><h1>Uninstall successful!</h1></center>";
				break;
		}
	}
?>
	<p>
		<?php _e('首先设置好Twitter的账户和密码。设置完毕后记得要保存设置哦！', 'ws-twitter-swell') ?>
	</p>
	<h3><?php _e('术语约定', 'ws-twitter-swell') ?></h3>
	<p>
		<?php
			_e('1. <b>登录窗体</b>：即登录博客时填写用户名，密码的窗体。<br />', 'ws-twitter-swell');
			_e('2. <b>Twitter发送窗体</b>：即输入你要发送的Twiiter信息框的窗体。<br />', 'ws-twitter-swell');
			_e('3. <b>Tweet窗体</b>：即显示Twitter信息的窗体。', 'ws-twitter-swell');
		?>
	</p>
	<p>
		<?php
			_e('在你想显示Twitter发送框的地方插入下列代码到你的主题当中即可：', 'ws-twitter-swell');
			echo '<br /><code style="color:#D64D21">&lt;?php if (function_exists(\'WSTS_ShowTwitter\')) : ?&gt;<br />
				&lt;?php WSTS_ShowTwitter(); ?&gt;<br />&lt;?php endif; ?&gt;</code><br />';
			_e('建议插入到你当前使用主题index.php文件<code style="color:#D64D21">&lt;?php if (have_posts()) : ?&gt;</code> 的上一行。', 'ws-twitter-swell');
		?>
	</p>
	<p>
		<?php
			echo __('同时，WSTS_ShowTwitter()函数还支持一个参数配置：', 'ws-twitter-swell').
			  '<br /><code style="color:#D64D21">WSTS_ShowTwitter($LoginForm={true|Fals})</code>
			   <br />'.__('默认使用可以省略参数，省略使用表示在未登录状态代码插入位置不显示登录窗体', 'ws-twitter-swell').
			  '<br />'.__('使用<code style="color:#D64D21">&lt;?php WSTS_TweetForm() ?&gt;</code>代码可以显示Tweet窗体。', 'ws-twitter-swell');

		?>
	</p>
	<p>

	</p>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>&updated=true" method="post" name="update_twitter">
		<inputt type="hidden" id="_wpnonce" name="do" value="update_user" />
		<h3>Common settings</h3>
		<table class="form-table">
			<tr class="form-field form">
				<th scope="row"><?php _e('Twitter用户名', 'ws-twitter-swell') ?></th>
				<td >
					<input name="WSTSuser" type="text" value="<?php echo $WSTSUser; ?>" />
					<?php _e('没有Twiiter账户？立即<a href="http://twitter.com/signup" target="_blank">申请一个Twiiter账户</a>。', 'ws-twitter-swell'); ?>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row"><?php _e('Twitter密码', 'ws-twitter-swell') ?></th>
				<td><input name="WSTSPwd" type="text" value="<?php echo $WSTSPwd; ?>" /></td>
			</tr>
		</table>

		<h3>Optional</h3>
		<table class="form-table">
			<tr class="form-field form">
				<th scope="row"><?php _e('显示信息个数', 'ws-twitter-swell') ?></th>
				<td><input name="WSTSMsgCount" type="text" value="<?php echo $WSTSMsgCount; ?>" /></td>
			</tr>
			<tr class="form-field">
				<th scope="row"><?php _e('附加信息', 'ws-twitter-swell') ?></th>
				<td>
					<label for="WSTSAddonsWordsFlag">
					<input type="checkbox" value="1" name="WSTSAddonsWordsFlag" <?php checked('1', get_option('WSTS_AddonsWordsFlag')); ?>/>
					<?php _e('在Twitter信息末尾附加插件名字。', 'ws-twitter-swell') ?></label>
				</td>
			</tr>
		</table>
		<p class="submit">
			<input name="wsts_do" type="submit" value="<?php _e('保存设置', 'ws-twitter-swell'); ?>" />
			<?php
				if ( get_option('WSTS_User') && get_option('WSTS_Pwd')){
			?>
			<input style="border:1px solid #D64D21;color:#D64D21;" name="wsts_do" type="submit" value="<?php _e('删除本插件', 'ws-twitter-swell'); ?>" />
			<?php } ?>
		</p
	</form>

<?php
	echo '</div>';
}

// Display Form of Send Twitter Box
function WSTS_ShowTwitter($LoginForm=false,$TweetFrom=false){
	global $user_ID, $user_identity;
	get_currentuserinfo();
	if($user_ID){
		$AddonsWords_Flag = get_option('WSTS_AddonsWords');
		if ($AddonsWords_Flag==="1"){
			$AddonsWords = __('(由Twitter Swell发送)', 'ws-twitter-swell');
			if ($AddonsWords=="(由Twitter Swell发送)"){
				$WordsCount = 140-18;
			}else{
				$WordsCount = 140-19;
			}
		}
		else{
			$AddonsWords = "";
			$WordsCount = 140;
		}

		echo '<div id="wsts-twitterform"><h2 class="wstsh2">'.__('你在做什么？', 'ws-twitter-swell').'</h2>
			<form method=post action="">
			<span class="right" id="wsts-chars-left-notice">
				<strong id="status-field-char-counter" style="gray">'.$WordsCount.'</strong>
			</span>
			<textarea rows="2" cols="40"  onkeyup="UpdateCharCounter(this.value, event);"
			onfocus="UpdateCharCounter(this.value, event); " name="message" id="wsts-message"
			onblur="UpdateCharCounter(this.value, event);"  /></textarea>
			<br>
			<center><input type="submit" name="wsts-update" value="Update" id="wsts-update" class="wsts-update"></center>
			</form>';

		echo "<script type=\"text/javascript\">
				function UpdateCharCounter(value, e) {
					len = value.length;
					jQuery('#status-field-char-counter').html('' + (".$WordsCount."-len));
					if (len > ".$WordsCount.") {
						if (jQuery(\"#wsts-update\").attr('disabled') != 'disabled') {
							jQuery('.wsts-update').attr('disabled', 'disabled');
							jQuery('.wsts-update').addClass('wsts-disabled');
							jQuery('.wsts-update').removeClass('wsts-update');
						}
					} else {
						if (jQuery(\"#wsts-update\").attr('disabled') == true) {
							jQuery('.wsts-disabled').removeAttr('disabled');
							jQuery('.wsts-disabled').addClass('wsts-update');
							jQuery('.wsts-disabled').removeClass('wsts-disabled');
						}

						if (len > 130) {
							jQuery('#status-field-char-counter').css('color', '#d40d12' );
						} else if (len > 120) {
							jQuery('#status-field-char-counter').css('color', '#5c0002' );
						} else {
							jQuery('#status-field-char-counter').css('color', '#cccccc' );
						}
					}
				}
			</script>";

		if(isset($_POST['message'])){
			if(($_POST['message'])===''){
				_e('你输入的信息为空！', 'ws-twitter-swell');
			}else{
				$Message = $_POST['message'];
				$Display_WSTSUser = get_option("WSTS_User");
				$Dispaly_WSTSPwd = get_option("WSTS_Pwd");

				//start curl call
				$url = 'http://twitter.com/statuses/update.xml';

				$curl_handle = curl_init();
				curl_setopt($curl_handle, CURLOPT_URL, "$url");
				curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
				curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl_handle, CURLOPT_POST, 1);
				curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "status=$Message $AddonsWords");
				curl_setopt($curl_handle, CURLOPT_USERPWD, "$Display_WSTSUser:$Dispaly_WSTSPwd");
				$buffer = curl_exec($curl_handle);
				curl_close($curl_handle);
				// check for success or failure
				if (empty($buffer)) {
					_e('发送失败。', 'ws-twitter-swell');
				} else {
					echo "<b>". __('信息', 'ws-twitter-swell') . ":</b>" . $Message;
				}
				//end curl call
			}
		}
		echo "</div>";
	}else{
		if($LoginForm){
			WSTS_LoginForm();
		}
	}
}

// Display Login From to blog
function WSTS_LoginForm(){
	echo '<div id="wsts-loginform">
			<form name="loginform" id="loginform" action="'.get_settings('siteurl').'/wp-login.php" method="post">
			<table>
				<tr>
					<td><lable id="wsts-username-lable">'.__('博客用户名', 'ws-twitter-swell').'</lable></td>
					<td><lable id="wsts-password-lable">'.__('博客密码', 'ws-twitter-swell').'</lable></td>
					<td></td>
				</tr>
				<tr>
					<td><input type="text" name="log" id="wsts-username-text" class="input" size="20" /></td>
					<td><input type="password" name="pwd" id="user-password-text" class="input" value="" size="20" /></td>
					<td><input type="submit" name="wsts-submit" id="ws-submit" value="'.__('登录博客', 'ws-twitter-swell').'" /></td>
			</table>
			</form>
		  </div>';
}

function WSTS_TweetForm(){
	echo '<div id="wsts-tweetform">
			<ul id="twitter_update_list" class="wsts-tweet-message">Loading...</ul>
		</div>';
}

// Display Warning Message
function WSTS_Warning(){
	if ( !get_option('WSTS_User')){
		echo "<div id='warning' class='updated fade'><p><strong>".__('Twitter Swell成功激活。', 'ws-twitter-swell')."</strong> ".
		sprintf(__('输入<a href="%1$s">Twitter用户名和密码</a>后Twitter Swell才能正常工作。', 'ws-twitter-swell'),
				"options-general.php?page=twitter-swell/twitter-swell.php")."</p></div>";
	}
}

// Add CSS & Javascript file
function WSTS_Header_Files(){
	echo "\n\t<!--[Header of Twitter Swell]-->\n";
	echo "\t<script src=\"" . get_option('siteurl') . "/wp-includes/js/jquery/jquery.js\" type=\"text/javascript\"></script>\n\t";
	echo '<link type="text/css" rel="stylesheet" href="' . get_option('siteurl') . '/wp-content/plugins/twitter-swell/css/wsts-style.css" />';
	echo "\n\t<!--[/Header of Twitter Swell]-->\n\n";
}

function WSTS_JS_Files(){
	$WSTSUser = get_option("WSTS_User");
	$WSTSCount = get_option("WSTS_MessageCount");
	echo "\n\t<!--[Bottom of Twitter Swell]-->\n";
	echo "\t<script type=\"text/javascript\" src=\"http://twitter.com/javascripts/blogger.js\"></script>";
	echo "\t<script text=\"text/javascript\" src=\"http://twitter.com/statuses/user_timeline/".$WSTSUser.".json?callback=twitterCallback2&count=".$WSTSCount."\"></script>";
	echo "\n\t<!--[/Bottom of Twitter Swell]-->\n\n";
}

// Add Options
add_action('admin_menu', 'WSTS_AdminMenu');
add_action('admin_notices', 'WSTS_Warning');
add_action('wp_head', 'WSTS_Header_Files');
add_action('wp_footer', 'WSTS_JS_Files');
?>
