<?php

class Login {

	private $core;

	public function __construct(){
		$this->core = core::getInstance();
	}

	public function verifyCredentials($email, $password){

		$query = new PDOQuery("SELECT `id`, `password`
			FROM `users`
			WHERE `email` = ?
			LIMIT 1
		");

		$query->execute($email);

		$fetch = $query->row();
		
		// Compare given password with stored user password hash
		if (password_verify($password, $fetch['password'])){
			return $fetch['id'];
		} else {
			return false;
		}

	}

}