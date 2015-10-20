<?php

class Login {

	private $core;

	public function __construct(){
		$this->core = core::getInstance();
	}

	public function verifyCredentials($username, $password){

		$query = new PDOQuery("SELECT `id`, `password`
			FROM `users`
			WHERE `username` = ?
			LIMIT 1
		");

		$query->execute($username);

		$fetch = $query->row();
		
		// Compare given password with stored user password hash
		if (password_verify($password, $fetch['password'])){
			return $fetch['id'];
		} else {
			return false;
		}

	}

}