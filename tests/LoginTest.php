<?php

class LoginTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * Test a set of login credentials
	 */
	public function testLogin(){

		$login = TaskerMAN\Application\Login::verifyCredentials('dkm2@aber.ac.uk', 'monaghan!');
		$this->assertInstanceOf('TaskerMAN\Application\User', $login);
	}

}