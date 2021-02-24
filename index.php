<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

@session_start();

define('DARQ', 1);
define('ROOT', __DIR__);

require ROOT . '/core/init.php';

echo '<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<!--[if lt IE 9]><script src="/static/html5.js"></script><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=1">
	<title>'.$title.'</title>
	<meta name="keywords" content="'.htmlspecialchars($keywords, ENT_QUOTES, 'utf-8').'" />
	<meta name="description" content="'.htmlspecialchars($description, ENT_QUOTES, 'utf-8').'" />
	<link rel="stylesheet" href="/static/styles.css.php?v='.time().'" type="text/css" />
	<link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
</head>
<body'.($body_class?' class="'.$body_class.'"':'').'>
<script type="text/javascript">
var logged = '.($logged ? 'true' : 'false').',
	user_group = '.($logged ? $_SESSION['group_id'] : 0).';
var config = {
};
</script>
'.printHeader().'
<div class="wrapper">
	<aside id="sidebar">
		<div class="hm">'.printHeaderMenu().'</div>
	</aside>
	<main id="content">
		'.$content.'
	</main>
</div>
'.print_system_layout().'
</body>
</html>';


?>