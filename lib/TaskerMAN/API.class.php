<?php
namespace TaskerMAN;

class API {
	
	static public $method;

	static public $uid;
	static public $is_admin;
	static public $token;

	static public function init(){

		self::$method = preg_replace("/[^A-Za-z0-9_ ]/", '', \IO::GET('method'));
		self::$token = \IO::GET('token');

		self::enforceLogin();
		self::execute();
	}

	static private function execute(){
		
		if (empty(self::$method) || !file_exists('api/' . self::$method . '.php')){
			throw new APIErrorException('Method not found');
		}

		require_once('api/' . self::$method . '.php');
	}

	static private function enforceLogin(){
		if (self::$method !== 'login' && !self::authenticateByToken()){
			throw new APIErrorException('Invalid API Authentication Token');
		}
	}

	static public function generateAPIToken(){
		return \Math::GenerateUUIDv4() . '-' . \Math::GenerateUUIDv4();
	}

	static public function setMethod($method){
		self::$method = preg_replace('/[^\w-]/', '', $method);
	}

	static public function authenticateByToken(){

		if (empty(self::$token)){
			return false;
		}

		$query = new \DBQuery("SELECT `id`, `admin`
			FROM `users`
			WHERE `api_token` = ?
			LIMIT 1
		");

		$query->execute(self::$token);

		if ($query->rowCount() < 1){
			return false;
		}

		$fetch = $query->row();
		self::$uid = (int) $fetch['id'];
		self::$is_admin = (bool) $fetch['admin'];

		return true;
	}

	static public function getUserAPIToken($uid){

		$query = new \DBQuery("SELECT `api_token`
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

	static public function response($data){
		return json_encode(array('status' => 'success', 'response' => $data));
	}

	static public function error($message){
		
		if (!is_array($message)){
			$message = array('message' => $message);
		}

		return json_encode(array('status' => 'error', 'error' => $message));
	}

}