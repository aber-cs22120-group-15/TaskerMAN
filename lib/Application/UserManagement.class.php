<?php
namespace TaskerMAN\Application;

/**
 * This class provides functions for manipulating user accounts
 *
 * @author Daniel K Monaghan <dkm2@aber.ac.uk>
 * @version 1.0
*/ 
class UserManagement {
	
	/**
	 * Creates a new user. Returns false if error, or the new user's id if success
	 *
	 * @param string $email
	 * @param string $name
	 * @param string $password
	 * @param boolean $admin
	 * @return mixed
	 * @throws UserManagementException
	*/
	static public function create($email, $name, $password, $admin = false){

		// Check if email is valid
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
			throw new UserManagementException('Invalid email ' . $email);
			return false;
		}

		// Validate password
		if (!self::validatePassword($password)){
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

		return (int) $query->lastInsertID();
	}

	/** 
	 * Updates information for a given user
	 * 
	 * @param int $id
	 * @param string $name
	 * @param string $email
	 * @param boolean $admin
	 * @throws UserManagementException
	 * @return boolean
	*/
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

	/**
	 * Verifies that a password meets the requirements
	 *
	 * @param string $password
	 * @return boolean
	 * @throws UserManagementException
	*/
	static public function validatePassword($password){

		// Check password length is between 5 and 13 characters
		if (strlen($password) < 5 || strlen($password) > 13){
			throw new UserManagementException('Password must be between 5 and 13 characters');
			return false;
		}

		// Check that password contains a special character
		if (!strpbrk($password, "@#$%^&*()+=-[]';,./{}|:<>?~!")){
			throw new UserManagementException('Password must contain at least one special character');
			return false;
		}

		return true;
	}

	/**
	 * Validates and sets a user's password
     *
     * @param int $uid
     * @param string $password
     * @return boolean
     * @throws UserManagementException
    */
	static public function changePassword($id, $password){

		// Validate password
		if (!self::validatePassword($password)){
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

	/** 
	 * Deletes a given user from the database
	 *
	 * @param int $id
	 * @return boolean
	*/
	static public function delete($id){

		// Do not allow deletion if only one user is registered
		$query = new \TaskerMAN\Core\DBQuery("SELECT COUNT(*) AS `rowCount`
			FROM `users`
			WHERE `admin` = '1'
		");

		$query->execute();
		$fetch = $query->row();

		if ($fetch['rowCount'] == 1){
			throw new UserManagementException('Cannot delete last remaining administrator');
			return false;
		}

		$query = new \TaskerMAN\Core\DBQuery("DELETE FROM `users`
			WHERE `id` = ?
			LIMIT 1
		");

		$query->execute($id);

		// Assign this user's tasks to currently logged in user
		$query = new \TaskerMAN\Core\DBQuery("UPDATE `tasks`
			SET `assignee_uid` = ?
			WHERE `assignee_uid` = ?
		");

		$query->execute(\TaskerMAN\WebInterface\WebInterface::$user->getID(), $id);

		// Make all tasks this user created to now be created by the currently logged in user
		$query = new \TaskerMAN\Core\DBQuery("UPDATE `tasks`
			SET `created_uid` = ?
			WHERE `created_uid` = ?
		");

		$query->execute(\TaskerMAN\WebInterface\WebInterface::$user->getID(), $id);

		return true;
	}

}