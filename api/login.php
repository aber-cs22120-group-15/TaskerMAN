<?php

$email = TaskerMAN\Core\IO::GET('email');
$password = TaskerMAN\Core\IO::GET('password');

if (empty($email) || empty($password)){
	throw new TaskerMAN\Application\APIErrorException('Requires email and password');
}

// Verify the user's login credentials
$user = TaskerMAN\Application\Login::verifyCredentials($email, $password);

// Login details incorrect
if (!$user){
	throw new TaskerMAN\Application\APIErrorException('Incorrect email or password');
}

// Login success, return API Token
echo TaskerMAN\Application\API::response(array('key' => $user->api_token));
