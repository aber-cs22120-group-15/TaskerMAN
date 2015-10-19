<?php
header('Content-type: application/json');

require_once('config/init.php');

$api = new api;

$api->setMethod($core->io->get('method'));

if ($api->method !== 'login'){
	$api->token = $core->io->get('token');

	// Authorize user
	if (!$api->authenticateByToken()){
		echo $api->error('Invalid API key');
		exit;
	}

}

if (empty($api->method)){
	echo $api->error('Method not found');
	exit;
}

if (!@include_once('api/' . $api->method . '.php')){
	echo $api->error('Method not found');
	exit;
}


