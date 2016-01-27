<?php
namespace TaskerMAN\Application;

/**
 * This class is used for verifying login credentials
 *
 * @author Daniel K Monaghan <dkm2@aber.ac.uk>
 * @version 1.0
*/ 
class Login {

	/**
	 * Validates a user with given email address and password,
	 * returns either boolean false or a User object with that user's
	 * information
	 *
	 * @param string $email
	 * @param string $password
	 * @return mixed Response
	*/
	static public function verifyCredentials($email, $password){

		$query = new \TaskerMAN\Core\DBQuery("SELECT `id`, `password`
			FROM `users`
			WHERE `email` = ?
			LIMIT 1
		");

		$query->execute($email);

		$fetch = $query->row();
		
		// Compare given password with stored user password hash
		if (password_verify($password, $fetch['password'])){
			return new User($fetch['id']);
		} else {
			return false;
		}

	}

}