<?php
require_once('config/init.php');

try {
	WebInterface\WebInterface::init();
} catch (FatalException $e){
	$e->display_html();
}