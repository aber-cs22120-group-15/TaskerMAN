<?php
require_once('config/init.php');

try {
	TaskerMAN\WebInterface\WebInterface::init();
} catch (FatalException $e){
	$e->display_html();
}