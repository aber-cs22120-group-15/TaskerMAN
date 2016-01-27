<?php
namespace TaskerMAN\Application;

/**
 * This class is an object containing all information about a user
 *
 * @author Daniel K Monaghan <dkm2@aber.ac.uk>
 * @version 1.0
*/ 
class User {
	
	public $id;
	public $email;
	public $name;
	public $admin;
	public $api_token;

	public $exists = false;

	/** 
	 * Initializes the object, takes a user ID and loads
	 * their information from the database
	 *
	 * @param int $id
	 */
	public function __construct($id){
		$this->id = $id;
		$this->exists = $this->load();
	}

	/**
	 * Loads user info into the object
	 *
	 * @return boolean
	*/
	private function load(){

		$query = new \TaskerMAN\Core\DBQuery("SELECT `email`, `name`, `admin`, `api_token`
			FROM `users`
			WHERE `id` = ?
			LIMIT 1
		");
		$query->execute($this->id);

		$fetch = $query->row();

		if (empty($fetch)){
			return false;
		}

		$this->email 		= $fetch['email'];
		$this->name 		= $fetch['name'];
		$this->admin 		= (bool) $fetch['admin'];
		$this->api_token 	= $fetch['api_token'];

		return true;
	}

	/**
	 * Returns user's uid
	 *
	 * @return int
	*/
	public function getID(){
		return $this->id;
	}

	/**
	 * Returns user's name
	 *
	 * @return string
	*/
	public function getName(){
		return $this->name;
	}

	/**
	 * Returns user's email adress
	 *
	 * @return string
	*/
	public function getEmail(){
		return $this->email;
	}

	/**
	 * Returns boolean indicating whether or not this user is an administrator
	 *
	 * @return boolean
	*/
	public function isAdmin(){
		return $this->admin;
	}

	/**
	 * Returns user's API token
	 *
	 * @return string
	*/
	public function getAPIToken(){
		return $this->api_token;
	}
}