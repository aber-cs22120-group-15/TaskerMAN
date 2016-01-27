<?php

class UserManagementTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * Test that the system allows valid passwords
	 */
	public function testValidPasswords(){

		$passwords = array('hello!', 'thiswill!work', 'but#will#this');
		foreach ($passwords as $password){
			$this->assertTrue(TaskerMAN\Application\UserManagement::validatePassword($password));
		}
	}

	/**
	 * Test that the system rejects invalid passwords
	 */
	public function testInvalidPasswords(){

		$this->setExpectedException('TaskerMAN\Application\UserManagementException');
		$passwords = array('nospecial', 'this_is_too_long_soz', 'numb3rs');

		foreach ($passwords as $password){
			$this->assertFalse(TaskerMAN\Application\UserManagement::validatePassword($password));
		}
	}


}