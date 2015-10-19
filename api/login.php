<?php

$username = $core->io->get('username');
$password = $core->io->get('password');

if (empty($username) || empty($password)){
	echo $api->error('Requires username and password');
	exit;
}
