<?php

class UserManagement {
	
	private $core;

	public function __construct(){

		$this->core = core::getInstance();
	}

	public function create($email, $name, $password, $admin = false){

		// Check if email is valid
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
			throw new UserManagementInvalidEmailException($email);
			return false;
		}

		// Check if user with this email already exists
		$query = new DBQuery("SELECT `email`
			FROM `users`
			WHERE `email` = ?
			LIMIT 1
		");
		$query->execute($email);

		if ($query->numRows() > 0){
			throw new UserManagementUserExistsException($email);
			return false;
		}

		// Hash password
		$password = password_hash($password, PASSWORD_DEFAULT);

		// Generate API Token
		$api_token = API::generateAPIToken();

		// Store user
		$query = new DBQuery("INSERT INTO `users`
			(`email`, `name`, `password`, `admin`, `api_token`)
			VALUES
			(:email, :name, :password, :admin, :api_token)
		");

		$query->bindValue(':email', $email);
		$query->bindValue(':name', $name);
		$query->bindValue(':password', $password);
		$query->bindValue(':admin', (int) $admin);
		$query->bindValue(':api_token', $api_token);

		$query->execute();

		return $query->lastInsertID();
	}

}