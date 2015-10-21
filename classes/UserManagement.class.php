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

	public function update($id, $name, $email, $admin){

		// Check if email is valid
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
			throw new UserManagementInvalidEmailException($email);
			return false;
		}

		$query = new DBQuery("UPDATE `users` SET
			`name` = :name,
			`email` = :email,
			`admin` = :admin

			WHERE `id` = :id
			LIMIT 1
		");

		$query->bindValue(':name', $name);
		$query->bindValue(':email', $email);
		$query->bindValue(':admin', (int) $admin);
		$query->bindValue(':id', $id);

		$query->execute();

		return true;
	}

	public function changePassword($id, $password){

		// Hash password
		$password = password_hash($password, PASSWORD_DEFAULT);

		// Generate new API Token
		$api_token = API::generateAPIToken();

		$query = new DBQuery("UPDATE `users` SET 
			`password` = :password,
			`api_token` = :api_token

			WHERE `id` = :id
			LIMIT 1
		");

		$query->bindValue(':password', $password);
		$query->bindValue(':api_token', $api_token);
		$query->bindValue(':id', $id);
		$query->execute();

		return true;
	}

	public function delete($id){

		// Do not allow deletion if only one user is registered
		$query = new DBQuery("SELECT COUNT(*) AS `rowCount`
			FROM `users`
		");

		$query->execute();
		$fetch = $query->row();

		if ($fetch['rowCount'] == 1){
			throw new UserManagementDeleteLastUserException();
			return false;
		}

		$query = new DBQuery("DELETE FROM `users`
			WHERE `id` = ?
			LIMIT 1
		");

		$query->execute($id);

		return true;
	}

}