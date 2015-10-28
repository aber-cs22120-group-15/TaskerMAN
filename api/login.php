<?php

$email = IO::GET('email');
$password = IO::GET('password');

if (empty($email) || empty($password)){
	throw new TaskerMAN\APIErrorException('Requires email and password');
}

// Verify the user's login credentials
$user = TaskerMAN\Login::verifyCredentials($email, $password);

// Login details incorrect
if (!$user){
	throw new TaskerMAN\APIErrorException('Incorrect email or password');
}

// Login success, return API Token
echo TaskerMAN\API::response(array('key' => $user->api_token));
