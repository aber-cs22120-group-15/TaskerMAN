<?php
header('Content-type: application/json');

require_once('config/init.php');

$API = new API;

$API->setMethod($core->IO->get('method'));

if ($API->method !== 'login'){
	$API->token = $core->IO->get('token');

	// Authorize user
	if (!$API->authenticateByToken()){
		echo $API->error('Invalid API key');
		exit;
	}

}

if (empty($API->method)){
	echo $API->error('Method not found');
	exit;
}

if (!@include_once('api/' . $API->method . '.php')){
	echo $API->error('Method not found');
	exit;
}


