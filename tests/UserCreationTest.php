<?php

class UserCreationTest extends PHPUnit_Framework_TestCase {
	
	private $name = 'Testing';
	private $email = 'testing@aber.ac.uk';
	private $password = 'aberystwyth!';
	private $admin = true;

	/**
	 * Test user creation
	 */
	public function testCreateUser(){

		$uid = TaskerMAN\Application\UserManagement::create($this->email, $this->name, $this->password, $this->admin);

		// Test that user was created correctly
		$this->assertTrue(is_numeric($uid));

		// Test loading the user
		$this->loadUser($uid);

		// Test that they can log in
		$this->login($uid);

		// Delete test user
		$this->deleteUser($uid);
	}

	/**
	 * Load user info from database
	 */
	public function loadUser($uid){
		$user = new TaskerMAN\Application\User($uid);

		$this->assertEquals($user->getID(), $uid);
		$this->assertEquals($user->getEmail(), $this->email);
		$this->assertEquals($user->getName(), $this->name);
		$this->assertEquals($user->isAdmin(), $this->admin);

	}

	/**
	 * Test login
	 */
	public function login($uid){

		$login = TaskerMAN\Application\Login::verifyCredentials($this->email, $this->password);

		$this->assertInstanceOf('TaskerMAN\Application\User', $login);

		// Verify it's returning the correct stuff
		$this->assertEquals($login->getID(), $uid);
		$this->assertEquals($login->getEmail(), $this->email);
		$this->assertEquals($login->getName(), $this->name);
		$this->assertEquals($login->isAdmin(), $this->admin);

		// Check API key is valid
		
		$API = TaskerMAN\Application\API::authenticateByToken($login->getAPIToken());
		$this->assertTrue($API);

	}


	/**
	 * Clean up and delete test user from database
	 */
	public function deleteUser($uid){

		$query = new TaskerMAN\Core\DBQuery("DELETE FROM `users`
			WHERE `id` = ?
			LIMIT 1
		");

		$query->execute($uid);

	}

}