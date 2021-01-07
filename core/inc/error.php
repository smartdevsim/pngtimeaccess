<?php
if(!defined('DARQ')) die();

header($_SERVER['SERVER_PROTOCOL']." 404 Not Found", true);

$title = 'Eror 404 - Not found';
$keywords = '';
$description = '';

if(!isset($error_page_text)) $error_page_text = '';

$content = '<div class="iw">
	<div style="margin-top: 60px;text-align: center;"><img src="/static/images/404.png" style="max-width: 100%;"></div>
	<div class="t" style="text-align: center;margin-top: 20px;font-size: 20px;font-family: \'Roboto\', sans-serif;">The page you were looking for was not found</div>
	<div class="e" style="text-align: center;font-family: \'Roboto\', sans-serif;font-size: 18px;margin: 30px 0 60px 0;">'.$error_page_text.'</div>
</div>';

?>