<?php

ob_start();
require_once('config/config.php');

// Initialize autoloader
function TaskerMANAutoloader($class){
	include('classes/' . $class . '.class.php');
}

spl_autoload_register('TaskerMANAutoloader');

// Build core object
$core = core::getInstance();

// Initialize database connections
$core->db = new mysql($config->mysql_host, $config->mysql_port, $config->mysql_user, $config->mysql_password, $config->mysql_db);
$core->io = new io;