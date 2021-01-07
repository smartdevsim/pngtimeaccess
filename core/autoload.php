<?php
if(!defined('DARQ')) die();
date_default_timezone_set('Pacific/Port_Moresby');
require ROOT . '/core/functions.php';
global $config;
$config = getConfig();
require ROOT . '/core/classes/db.php';
require ROOT . '/core/auth.php';
#define('ST_EXAMS', ROOT . $config['st_exams']);

?>