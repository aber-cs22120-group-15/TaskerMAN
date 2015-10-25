<?php

$email = $core->IO->get('email');
$password = $core->IO->get('password');

if (empty($email) || empty($password)){
	echo $API->error('Requires email and password');
	exit;
}

// Verify the user's login credentials
$login = new Login;
$user = $login->verifyCredentials($email, $password);

// Login details incorrect
if (!$user){
	echo $API->error('Incorrect email or password');
	exit;
}

// Login success, return API Token
echo $API->response(array('key' => $user->api_token));
exit;