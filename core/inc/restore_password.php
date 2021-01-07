<?php
if(!defined('DARQ')) die();

$title = 'Restore Password';

$error = '';
$success = false;

$alt_name = isset($_GET['id']) ? trim(strip_tags($_GET['id'])) : '';
$token = isset($_GET['token']) ? trim(strip_tags($_GET['token'])) : '';

if(!($alt_name AND $token)) $error = 'Wrong Request';

$row = $db->super_query("SELECT id, email, restore_token FROM users WHERE alt_name = '".$db->safesql($alt_name)."'");
if(!$row['id']){
	$error = 'Wrong Request';
}

$restore_link_token = hash('sha256', $row['restore_token'].sha1($config['domain'].date('dmY')));
if($restore_link_token != $token){
	$error = 'Wrong Request';
}

if(isset($_POST['newpassword'])){
	$password = isset($_POST['newpassword']) ? $_POST['newpassword'] : '';

	if(strlen($password)<6) die();
	
	$pass = hash('sha512', sha1($password));
	$token = hash('sha256', sha1(uniqid().$config['domain'].$row['email'].$pass.time()));


	$db->query("UPDATE users SET restore_token = '', password = '".$pass."', token = '".$token."' WHERE id = ".$row['id']);

	$success = true;

}

$content = '
<div class="cs-content" style="margin-top: 0">
	<div class="iw">
		<div class="iwc">
			
			<div class="left-col">
				<div class="wrap">
		<div class="account">
			<h1 class="h1">Change your password</div>
			<form id="restore-form" method="post" action="">
			<div class="regform">
				<div id="reg-error">'.($error?'<div class="error" style="margin-left: 0;">'.$error.'</div>':'').'</div>
				'.((!$error AND !$success) ? '<div class="row">
					<div class="name">New Password: *</div>
					<div class="data">
						<input id="reg-password" name="newpassword" type="password" placeholder="Password" />
						<input id="reg-password2" type="password" placeholder="Repeat password" />
					</div>
				</div>
				<div class="row">
					<div class="submit" onclick="changePassword();">Change password</div>
				</div>':'').($success ? '<h3 class="h3">Your password has been changed!</h3><div><div style="background: rgba(0, 166, 128, 0.21);cursor: pointer;display: inline-block;font-size: 14px;margin-left: 15px;padding: 15px 30px;" onclick="showLogin();">Sign In Now</div></div>':'').'
			</div>
			</form>
		</div>
			</div>
			
		</div>
	</div>
</div>
';

?>