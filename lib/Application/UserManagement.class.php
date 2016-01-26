<?php
namespace TaskerMAN\Application;

class UserManagement {
	
	static public function create($email, $name, $password, $admin = false){

		// Check if email is valid
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
			throw new UserManagementException('Invalid email ' . $email);
			return false;
		}

		// Validate password
		if (strlen($password) < 5 || strlen($password) > 13){
			throw new UserManagementException('Password must be between 5 and 13 characters');
			return false;
		}

		// Validate username
		if (empty($name) || strlen($name) > 50){
			throw new UserManagementException('Name cannot be empty, and no more than 50 characters');
			return false;
		}

		// Check if user with this email already exists
		$query = new \TaskerMAN\Core\DBQuery("SELECT `email`
			FROM `users`
			WHERE `email` = ?
			LIMIT 1
		");
		$query->execute($email);

		if ($query->rowCount() > 0){
			throw new UserManagementException('User with email ' . $email . ' already exists');
			return false;
		}

		// Hash password
		$password = password_hash($password, PASSWORD_DEFAULT);

		// Generate API Token
		$api_token = API::generateAPIToken();

		// Store user
		$query = new \TaskerMAN\Core\DBQuery("INSERT INTO `users`
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

	static public function update($id, $name, $email, $admin){

		// Check if email is valid
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
			throw new UserManagementException('Invalid email ' . $email);
			return false;
		}

		// Validate username
		if (empty($name) || strlen($name) > 50){
			throw new UserManagementException('Name cannot be empty, and no more than 50 characters');
			return false;
		}

		$query = new \TaskerMAN\Core\DBQuery("UPDATE `users` SET
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

	static public function changePassword($id, $password){

		if (strlen($password) < 5 || strlen($password) > 13){
			throw new UserManagementException('Password must be between 5 and 13 characters');
			return false;
		}

		// Hash password
		$password = password_hash($password, PASSWORD_DEFAULT);

		// Generate new API Token
		$api_token = API::generateAPIToken();

		$query = new \TaskerMAN\Core\DBQuery("UPDATE `users` SET 
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

	static public function delete($id){

		// Do not allow deletion if only one user is registered
		$query = new \TaskerMAN\Core\DBQuery("SELECT COUNT(*) AS `rowCount`
			FROM `users`
		");

		$query->execute();
		$fetch = $query->row();

		if ($fetch['rowCount'] == 1){
			throw new UserManagementException('Cannot delete last remaining user');
			return false;
		}

		$query = new \TaskerMAN\Core\DBQuery("DELETE FROM `users`
			WHERE `id` = ?
			LIMIT 1
		");

		$query->execute($id);

		// Unassign all tasks which were assigned to this user
		$query = new \TaskerMAN\Core\DBQuery("UPDATE `tasks`
			SET `assignee_uid` = NULL
			WHERE `assignee_uid` = ?
		");

		$query->execute($id);

		return true;
	}

}