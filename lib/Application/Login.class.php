<?php
namespace TaskerMAN\Application;

class Login {

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