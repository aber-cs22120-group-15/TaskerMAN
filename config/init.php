<?php

ob_start();
error_reporting(E_ALL);
require_once('config/config.php');

// Initialize autoloader
function TaskerMANAutoloader($class){
	if (substr($class, strlen($class) - 9) == 'Exception'){
		require_once('exceptions/' . $class . '.class.php');
	} else {
		include('classes/' . $class . '.class.php');
	}
}

spl_autoload_register('TaskerMANAutoloader');

// Build core object
$core = core::getInstance();

// Initialize database connections
$core->PDOConnection = new PDOConnection($config->mysql_host, $config->mysql_user, $config->mysql_password, $config->mysql_db);
$core->IO = new IO;
$core->Session = new Session;
$core->Page = new Page;