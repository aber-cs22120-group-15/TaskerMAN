<?php

class APITest extends PHPUnit_Framework_TestCase {
	
	/**
	 * Check that API tokens are generating at the right length
	 * and are not the same
	 */
	public function testTokens(){

		$token1 = TaskerMAN\Application\API::generateAPIToken();
		$this->assertEquals(73, strlen($token1));

		// Make sure this method is not returning the same token multiple times
		$token2 = TaskerMAN\Application\API::generateAPIToken();
		$this->assertNotEquals($token1, $token2);

	}

	/** 
	 * Check that an invalid token won't allow a user to be authenticated
	 * Note that checking of a valid token is performed in UserCreationTest
	 */
	public function testInvalidTokenAuthentication(){
		$token = 'NOT-A-REAL-TOKEN';

		$response = TaskerMAN\Application\API::authenticateByToken($token);
		$this->assertFalse($response);
	}
}