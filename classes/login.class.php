<?php

class login {

	private $core;

	public function __construct(){
		$this->core = core::getInstance();
	}

	public function verifyCredentials($username, $password){

		$query = $this->core->db->query("SELECT `id`, `password`
			FROM `users`
			WHERE `username` = '$username'
			LIMIT 1
		");

		$fetch = $query->fetch_assoc();

		// Compare given password with stored user password hash
		if (password_verify($password, $fetch['password'])){
			return $fetch['id'];
		} else {
			return false;
		}

	}

}