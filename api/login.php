<?php

$username = $core->IO->get('username');
$password = $core->IO->get('password');

if (empty($username) || empty($password)){
	echo $API->error('Requires username and password');
	exit;
}

// Verify the user's login credentials
$login = new Login;
$uid = $login->verifyCredentials($username, $password);

// Login details incorrect
if ($uid === FALSE){
	echo $API->error('Incorrect username or password');
	exit;
}

// Login success, return API Token
echo $API->response(array('key' => $api->getUserAPIToken($uid)));
exit;