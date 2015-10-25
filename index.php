<?php
// Load in configs
require_once('config/init.php');


// Determine which page the user wants to see
if (isset($_GET['p']) && !empty($_GET['p'])){
	$core->Page->setPage(preg_replace("/[^A-Za-z0-9_ ]/", '', $core->IO->get('p')));

	if (!file_exists('pages/' . $core->Page->page . '.php')){
		$core->Page->page = '404';
	}
} else {
	$core->Page->page = 'main';
}

require_once('config/login_enforcement.php');

ob_start();
require_once('pages/' . $core->Page->page . '.php');
$ob = ob_get_contents();
ob_end_clean();

if ($core->Page->showTemplate){ require_once('template/header.php'); }
echo $ob;
if ($core->Page->showTemplate){ require_once('template/footer.php'); }
?>