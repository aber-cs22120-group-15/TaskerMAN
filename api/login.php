<?php

$email = IO::GET('email');
$password = IO::GET('password');

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