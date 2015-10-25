<?php

class User {
	
	public $id;
	public $email;
	public $name;
	public $admin;
	public $api_token;

	public function __construct($id){

		$this->id = $id;
		$this->load();
	}

	public function load(){

		$query = new PDOQuery("SELECT `email`, `name`, `admin`, `api_token`
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
}