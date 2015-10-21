<?php

$email = $core->IO->get('email');
$password = $core->IO->get('password');

if (empty($email) || empty($password)){
	echo $API->error('Requires email and password');
	exit;
}

// Verify the user's login credentials
$login = new Login;
$uid = $login->verifyCredentials($email, $password);

// Login details incorrect
if ($uid === FALSE){
	echo $API->error('Incorrect email or password');
	exit;
}

// Login success, return API Token
echo $API->response(array('key' => $api->getUserAPIToken($uid)));
exit;