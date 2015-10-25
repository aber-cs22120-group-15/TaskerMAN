<?php

// Enforce login

if (!$core->Session->isLoggedIn() && $core->Page->page !== 'login' && $core->Page->page !== '404'){
	// Not logged in and trying to access page that isn't the login page, redirect
	// to login page
	header('Location: index.php?p=login');
	exit;
}