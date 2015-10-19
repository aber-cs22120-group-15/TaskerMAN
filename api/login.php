<?php

$username = $core->io->get('username');
$password = $core->io->get('password');

if (empty($username) || empty($password)){
	echo $api->error('Requires username and password');
	exit;
}

// Verify the user's login credentials
$login = new login;
$uid = $login->verifyCredentials($username, $password);

// Login details incorrect
if ($uid === FALSE){
	echo $api->error('Incorrect username or password');
	exit;
}

// Login success, return API Token
echo $api->response(array('key' => $api->getUserAPIToken($uid)));
exit;