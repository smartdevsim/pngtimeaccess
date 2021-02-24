<?php
if(!defined('DARQ')) die();

$logged = false;

if(isset($_COOKIE['sb_id']) AND $_COOKIE['sb_id'] AND isset($_COOKIE['sb_token']) AND $_COOKIE['sb_token']){
	@session_start();
	if(isset($_SESSION['logged']) AND $_SESSION['logged']){
		$logged = true;
	} else {

		$auth_an = trim(strip_tags($_COOKIE['sb_id']));
		$auth_token = trim(strip_tags($_COOKIE['sb_token']));

		if(!($auth_an AND $auth_token)) die('Server error');

		$row = $db->super_query("SELECT * FROM users WHERE alt_name = '".$db->safesql($auth_an)."' AND token = '".$db->safesql($auth_token)."'");
		if(isset($row['id']) AND $row['id']){

			$auth_token = hash('sha256', sha1($config['domain'].$row['email'].$row['password'].time()));

			$db->query("UPDATE users SET lastdate='".time()."', token = '".$auth_token."' WHERE id = ".$row['id']);

			$logged = true;

			sb_setcookie('sb_id', $row['alt_name']);
			sb_setcookie('sb_token', $auth_token);

			@session_start();

			setUserData($row);

		} else {

			@session_destroy();

			sb_delcookie('sb_id');
			sb_delcookie('sb_token');

		}
		//del cookie
	}
}


?>