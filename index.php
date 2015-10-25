<?php
// Load in configs
require_once('config/init.php');


// Determine which page the user wants to see
if (isset($_GET['p'])){
	$page = preg_replace("/[^A-Za-z0-9 ]/", '', $core->IO->get('p'));

	if (!file_exists('pages/' . $page . '.php')){
		$page = '404';
	}
} else {
	$page = 'main';
}

require_once('config/login_enforcement.php');

ob_start();
require_once('pages/' . $page . '.php');
$ob = ob_get_contents();
ob_end_clean();

require_once('template/header.php');
echo $ob;
require_once('template/footer.php');
?>