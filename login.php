<?php

/**
 * Copyright (C) 2008-2012 FluxBB
 * based on code by Rickard Andersson copyright (C) 2002-2008 PunBB
 * License: http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 */

if (isset($_GET['action']))
	define('PUN_QUIET_VISIT', 1);

define('PUN_ROOT', dirname(__FILE__).'/bbs/');
require PUN_ROOT.'include/common.php';

// 2015-02-08, duangan
require_once 'init.php';
require_once "data.php";
define("PAGE_TYPE", $lang_common['Login']);

// Load the login.php language file
require PUN_ROOT.'lang/'.$pun_user['language'].'/login.php';

$action = isset($_GET['action']) ? $_GET['action'] : null;

// 登录之后.
if (isset($_POST['form_sent']) && $action == 'in')
{
	flux_hook('login_before_validation');

	$form_username = pun_trim($_POST['req_username']);
	$form_password = pun_trim($_POST['req_password']);
	$save_pass = isset($_POST['save_pass']);

	$username_sql = ($db_type == 'mysql' || $db_type == 'mysqli' || $db_type == 'mysql_innodb' || $db_type == 'mysqli_innodb') ? 'username=\''.$db->escape($form_username).'\'' : 'LOWER(username)=LOWER(\''.$db->escape($form_username).'\')';

	$result = $db->query('SELECT * FROM '.$db->prefix.'users WHERE '.$username_sql) or error('Unable to fetch user info', __FILE__, __LINE__, $db->error());
	$cur_user = $db->fetch_assoc($result);

	$authorized = false;

	if (!empty($cur_user['password']))
	{
		$form_password_hash = pun_hash($form_password); // Will result in a SHA-1 hash
		
		// 2015-02-08
		$authorized = ($cur_user['password'] == $form_password_hash);
        user_login($form_username, $cur_user['user_UUID'], $cur_user['group_id']);
	}

    // 密码错, 进入忘记密码流程.
	if (!$authorized)
    {
		message_user($lang_login['Wrong user/pass'].' <a href="login.php?action=forget">'.$lang_login['Forgotten pass'].'</a>');
    }
	flux_hook('login_after_validation');

	// Update the status if this is the first time the user logged in
	if ($cur_user['group_id'] == PUN_UNVERIFIED)
	{
		$db->query('UPDATE '.$db->prefix.'users SET group_id='.$pun_config['o_default_user_group'].' WHERE id='.$cur_user['id']) or error('Unable to update user status', __FILE__, __LINE__, $db->error());

		// Regenerate the users info cache
		if (!defined('FORUM_CACHE_FUNCTIONS_LOADED'))
			require PUN_ROOT.'include/cache.php';

		generate_users_info_cache();
	}

	// Remove this user's guest entry from the online list
	$db->query('DELETE FROM '.$db->prefix.'online WHERE ident=\''.$db->escape(get_remote_address()).'\'') or error('Unable to delete from online list', __FILE__, __LINE__, $db->error());

	$expire = ($save_pass == '1') ? time() + 1209600 : time() + $pun_config['o_timeout_visit'];
	pun_setcookie($cur_user['id'], $form_password_hash, $expire);

	// Reset tracked topics
	set_tracked_topics(null);

    // 2015-02-08
	// Try to determine if the data in redirect_url is valid (if not, we redirect to index.php after login)
	$redirect_url = validate_redirect($_POST['redirect_url'], '../item_frame.php');

	redirect(pun_htmlspecialchars($redirect_url), $lang_login['Login redirect']);
}

// 退出登录
else if ($action == 'out')
{
	if ($pun_user['is_guest'] || !isset($_GET['id']) || $_GET['id'] != $pun_user['id'] 
	   || !isset($_GET['csrf_token']) || $_GET['csrf_token'] != 
	   pun_hash($pun_user['id'].pun_hash(get_remote_address())))
	{
	    header('Location: login.php');
		exit;
	}

	// Remove user from "users online" list
	$db->query('DELETE FROM '.$db->prefix.'online WHERE user_id='.$pun_user['id']) or error('Unable to delete from online list', __FILE__, __LINE__, $db->error());

	// Update last_visit (make sure there's something to update it with)
	if (isset($pun_user['logged']))
		$db->query('UPDATE '.$db->prefix.'users SET last_visit='.$pun_user['logged'].' WHERE id='.$pun_user['id']) or error('Unable to update user visit data', __FILE__, __LINE__, $db->error());

	pun_setcookie(1, pun_hash(uniqid(rand(), true)), time() + 31536000);
    
    // 2015-02-08
    user_logout();

	// redirect('./item_frame.php', $lang_login['Logout redirect']);
}

// 忘记密码.
else if ($action == 'forget' || $action == 'forget_2')
{
	if (!$pun_user['is_guest'])
	{
		header('Location: ./item_frame.php');
		exit;
	}

	if (isset($_POST['form_sent']))
	{
		flux_hook('forget_password_before_validation');

		// Start with a clean slate
		$errors = array();

		require PUN_ROOT.'include/email.php';

		// Validate the email address
		$email = strtolower(pun_trim($_POST['req_email']));
		if (!is_valid_email($email))
			$errors[] = $lang_common['Invalid email'];

		flux_hook('forget_password_after_validation');

		// Did everything go according to plan?
		if (empty($errors))
		{
			$result = $db->query('SELECT id, username, last_email_sent FROM '.$db->prefix.'users WHERE email=\''.$db->escape($email).'\'') or error('Unable to fetch user info', __FILE__, __LINE__, $db->error());

			if ($db->num_rows($result))
			{
				// Load the "activate password" template
				$mail_tpl = trim(file_get_contents(PUN_ROOT.'lang/'.$pun_user['language'].'/mail_templates/activate_password.tpl'));

				// The first row contains the subject
				$first_crlf = strpos($mail_tpl, "\n");
				$mail_subject = trim(substr($mail_tpl, 8, $first_crlf-8));
				$mail_message = trim(substr($mail_tpl, $first_crlf));

				// Do the generic replacements first (they apply to all emails sent out here)
				$mail_message = str_replace('<base_url>', get_base_url().'/', $mail_message);
				$mail_message = str_replace('<board_mailer>', get_system_name(), $mail_message);

				// Loop through users we found
				while ($cur_hit = $db->fetch_assoc($result))
				{
					if ($cur_hit['last_email_sent'] != '' && (time() - $cur_hit['last_email_sent']) < 3600 && (time() - $cur_hit['last_email_sent']) >= 0)
						message_user(sprintf($lang_login['Email flood'], intval((3600 - (time() - $cur_hit['last_email_sent'])) / 60)), true);

					// Generate a new password and a new password activation code
					$new_password = random_pass(12);
					$new_password_key = random_pass(8);

					$db->query('UPDATE '.$db->prefix.'users SET activate_string=\''.pun_hash($new_password).'\', activate_key=\''.$new_password_key.'\', last_email_sent = '.time().' WHERE id='.$cur_hit['id']) or error('Unable to update activation data', __FILE__, __LINE__, $db->error());

					// Do the user specific replacements to the template
					$cur_mail_message = str_replace('<username>', $cur_hit['username'], $mail_message);
					$cur_mail_message = str_replace('<activation_url>', get_base_url().'/profile.php?id='.$cur_hit['id'].'&action=change_pass&key='.$new_password_key, $cur_mail_message);
					$cur_mail_message = str_replace('<new_password>', $new_password, $cur_mail_message);

					pun_mail($email, $mail_subject, $cur_mail_message);
				}

				message_user($lang_login['Forget mail'].' <a href="mailto:'.pun_htmlspecialchars($pun_config['o_admin_email']).'">'.pun_htmlspecialchars($pun_config['o_admin_email']).'</a>.', true);
			}
			else
				$errors[] = $lang_login['No email match'].' '.htmlspecialchars($email).'.';
			}
		}

	$page_title = array(pun_htmlspecialchars(get_system_name()), $lang_login['Request pass']);
	$required_fields = array('req_email' => $lang_common['Email']);
	$focus_element = array('request_pass', 'req_email');

	flux_hook('forget_password_before_header');

	define ('PUN_ACTIVE_PAGE', 'login');
	require 'header_user.php';

// If there are errors, we display them
if (!empty($errors))
{

?>
<div id="posterror" class="block">
	<h2><span><?php echo $lang_login['New password errors'] ?></span></h2>
	<div class="box">
		<div class="inbox error-info">
			<p><?php echo $lang_login['New passworderrors info'] ?></p>
			<ul class="error-list">
<?php

	foreach ($errors as $cur_error)
		echo "\t\t\t\t".'<li><strong>'.$cur_error.'</strong></li>'."\n";
?>
			</ul>
		</div>
	</div>
</div>

<?php

}
?>
<div class="blockform">
	<h2><span><?php echo $lang_login['Request pass'] ?></span></h2>
	<div class="box">
		<form id="request_pass" method="post" action="login.php?action=forget_2" onsubmit="this.request_pass.disabled=true;if(process_form(this)){return true;}else{this.request_pass.disabled=false;return false;}">
			<div class="inform">
				<fieldset>
					<legend><?php echo $lang_login['Request pass legend'] ?></legend>
					<div class="infldset">
						<input type="hidden" name="form_sent" value="1" />
						<label class="required"><strong><?php echo $lang_common['Email'] ?> <span><?php echo $lang_common['Required'] ?></span></strong><br /><input id="req_email" type="text" name="req_email" size="50" maxlength="80" /><br /></label>
						<p><?php echo $lang_login['Request pass info'] ?></p>
					</div>
				</fieldset>
			</div>
<?php flux_hook('forget_password_before_submit') ?>
			<p class="buttons"><input type="submit" name="request_pass" value="<?php echo $lang_common['Submit'] ?>" /><?php if (empty($errors)): ?> <a href="javascript:history.go(-1)"><?php echo $lang_common['Go back'] ?></a><?php endif; ?></p>
		</form>
	</div>
</div>
<?php

	require 'footer_user.php';
}


if (!$pun_user['is_guest'])
{
	header('Location: ./item_frame.php');
	exit;
}

// Try to determine if the data in HTTP_REFERER is valid (if not, we redirect to index.php after login)
if (!empty($_SERVER['HTTP_REFERER']))
	$redirect_url = validate_redirect($_SERVER['HTTP_REFERER'], null);

if (!isset($redirect_url))
	$redirect_url = get_base_url(true).'../item_frame.php';
else if (preg_match('%viewtopic\.php\?pid=(\d+)$%', $redirect_url, $matches))
	$redirect_url .= '#p'.$matches[1];

$page_title = array(pun_htmlspecialchars(get_system_name()), $lang_common['Login']);
$required_fields = array('req_username' => $lang_common['Username'], 'req_password' => $lang_common['Password']);
$focus_element = array('login', 'req_username');

flux_hook('login_before_header');

define('PUN_ACTIVE_PAGE', 'login');
require 'header_user.php';

?>
<div class="blockform">
	<h2><span><?php echo $lang_common['Login'] ?></span></h2>
	<div class="box">
		<form id="login" method="post" action="login.php?action=in" onsubmit="return process_form(this)">
			<div class="inform">
				<fieldset>
					<legend><?php echo $lang_login['Login legend'] ?></legend>
					<div class="infldset">
						<input type="hidden" name="form_sent" value="1" />
						<input type="hidden" name="redirect_url" value="<?php echo pun_htmlspecialchars($redirect_url) ?>" />
						<label class="conl required"><strong><?php echo $lang_common['Username'] ?> <span><?php echo $lang_common['Required'] ?></span></strong><br /><input type="text" name="req_username" size="25" maxlength="25" tabindex="1" /><br /></label>
						<label class="conl required"><strong><?php echo $lang_common['Password'] ?> <span><?php echo $lang_common['Required'] ?></span></strong><br /><input type="password" name="req_password" size="25" tabindex="2" /><br /></label>

						<div class="rbox clearb">
							<label><input type="checkbox" name="save_pass" value="1" tabindex="3" /><?php echo $lang_login['Remember me'] ?><br /></label>
						</div>

						<p class="clearb"><?php echo $lang_login['Login info'] ?></p>
						<p class="actions">
						    <span><a href="register.php" tabindex="5" style="font-size:17px;"><?php echo $lang_login['Not registered'] ?></a></span>
						    &nbsp;&nbsp;&nbsp;<span><a href="login.php?action=forget" tabindex="6"><?php echo $lang_login['Forgotten pass'] ?></a></span>
						    &nbsp;&nbsp;&nbsp;<span><a href="./bbs/index.php" tabindex="7">以访客身份访问</a></span>
						    </p>
					</div>
				</fieldset>
			</div>
<?php flux_hook('login_before_submit') ?>
			<p class="buttons"><input type="submit" name="login" value="<?php echo $lang_common['Login'] ?>" tabindex="4" /></p>
		</form>
	</div>
</div>
<?php

require 'footer_user.php';
