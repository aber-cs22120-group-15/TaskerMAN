<?php

class api {
	
	private $core;
	private $data;

	public $method;

	public $uid;
	public $is_admin;
	public $token;

	public function __construct(){
		$this->core = core::getInstance();
	}

	static public function GenerateAPIToken(){
		return math::GenerateUUIDv4() . '-' . math::GenerateUUIDv4();
	}

	public function setMethod($method){
		$this->method = preg_replace('/[^\w-]/', '', $method);
	}

	public function authenticateByToken(){

		if (empty($this->token)){
			return false;
		}

		$query = $this->core->db->query("SELECT `id`, `admin`
			FROM `users`
			WHERE `api_token` = '$this->token'
			LIMIT 1
		");

		if ($query->num_rows < 1){
			return false;
		}

		$fetch = $query->fetch_assoc();
		$this->uid = $fetch['id'];
		$this->is_admin = (bool) $fetch['admin'];

		return true;
	}

	public function getUserAPIToken($uid){

		$query = $this->core->db->query("SELECT `api_token`
			FROM `users`
			WHERE `id` = '$uid'
			LIMIT 1
		");

		if ($query->num_rows < 1){
			return false;
		}

		$fetch = $query->fetch_assoc();
		return $fetch['api_token'];
	}

	public function response($data){
		return json_encode(array('status' => 'success', 'response' => $data));
	}

	public function error($message){
		return json_encode(array('status' => 'error', 'error' => $message));
	}

}