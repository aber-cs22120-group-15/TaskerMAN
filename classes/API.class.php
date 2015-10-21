<?php

class API {
	
	private $core;
	private $data;

	public $method;

	public $uid;
	public $is_admin;
	public $token;

	public function __construct(){
		$this->core = core::getInstance();
	}

	static public function generateAPIToken(){
		return Math::GenerateUUIDv4() . '-' . math::GenerateUUIDv4();
	}

	public function setMethod($method){
		$this->method = preg_replace('/[^\w-]/', '', $method);
	}

	public function authenticateByToken(){

		if (empty($this->token)){
			return false;
		}

		$query = new PDOQuery("SELECT `id`, `admin`
			FROM `users`
			WHERE `api_token` = ?
			LIMIT 1
		");

		$query->execute($this->token);

		if ($query->rowCount() < 1){
			return false;
		}

		$fetch = $query->row();
		$this->uid = (int) $fetch['id'];
		$this->is_admin = (bool) $fetch['admin'];

		return true;
	}

	public function getUserAPIToken($uid){

		$query = new PDOQuery("SELECT `api_token`
			FROM `users`
			WHERE `id` = ?
			LIMIT 1
		");

		$query->execute($uid);

		if ($query->rowCount() < 1){
			return false;
		}

		$fetch = $query->row();
		return $fetch['api_token'];
	}

	public function response($data){
		return json_encode(array('status' => 'success', 'response' => $data));
	}

	public function error($message){
		return json_encode(array('status' => 'error', 'error' => $message));
	}

}