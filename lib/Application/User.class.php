<?php
namespace TaskerMAN\Application;

class User {
	
	public $id;
	public $email;
	public $name;
	public $admin;
	public $api_token;

	public $exists = false;

	public function __construct($id){

		$this->id = $id;
		$this->exists = $this->load();
	}

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

	public function getID(){
		return $this->id;
	}

	public function getName(){
		return $this->name;
	}

	public function getEmail(){
		return $this->email;
	}

	public function isAdmin(){
		return $this->admin;
	}

	public function getAPIToken(){
		return $this->api_token;
	}
}