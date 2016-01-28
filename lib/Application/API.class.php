<?php
namespace TaskerMAN\Application;


/**
 * This class handles all interactions with the API, including formatting responses
 * and authenticatin via API tokens.
 *
 * @author Daniel K Monaghan <dkm2@aber.ac.uk>
 * @version 1.0
*/
class API {
	
	static public $method;

	static public $uid;
	static public $is_admin;
	static public $token;


	/**
	 * Initialize API by loading the user's token and enforcing authorization
	 *
	 * @return null
	*/
	static public function init(){

		self::$method = preg_replace("/[^A-Za-z0-9_ ]/", '', \TaskerMAN\Core\IO::GET('method'));
		self::$token = \TaskerMAN\Core\IO::GET('token');

		self::enforceLogin();
		self::execute();
	}

	/**
	 * Loads the given API method
	 *
	 * @return null
	*/
	static private function execute(){
		
		// Check the requested method exists
		if (empty(self::$method) || !file_exists('api/' . self::$method . '.php')){
			throw new \TaskerMAN\Application\APIErrorException('Method not found');
		}

		require_once('api/' . self::$method . '.php');
	}

	/**
	 * Enforce user login
	 *
	 * @return null
	*/
	static private function enforceLogin(){
		if (self::$method !== 'login' && self::$method!== 'online' && !self::authenticateByToken()){
			throw new \TaskerMAN\Application\APIErrorException('Invalid API Authentication Token');
		}
	}

	/**
	 * Generates an API token in the form of two UUID V4 tokens
	 *
	 * @return string API token
	*/
	static public function generateAPIToken(){
		return \TaskerMAN\Core\Math::GenerateUUIDv4() . '-' . \TaskerMAN\Core\Math::GenerateUUIDv4();
	}

	/**
	 * Set the method which will be executed
	 *
	 * @param string $method Requested method
	 * @return null
	*/
	static public function setMethod($method){
		self::$method = preg_replace('/[^\w-]/', '', $method);
	}

	/**
	 * Authenticate a user with given token
	 *
	 * @return boolean Success
	*/
	static public function authenticateByToken($token = null){

		if (is_null($token)){
			$token = self::$token;
		}

		if (empty($token)){
			return false;
		}

		$query = new \TaskerMAN\Core\DBQuery("SELECT `id`, `admin`
			FROM `users`
			WHERE `api_token` = ?
			LIMIT 1
		");

		$query->execute($token);

		if ($query->rowCount() < 1){
			return false;
		}

		$fetch = $query->row();
		self::$uid = (int) $fetch['id'];
		self::$is_admin = (bool) $fetch['admin'];

		return true;
	}

	/**
	 * Returns the API token for a given user id
	 *
	 * @param int user id
	 * @return string API Token
	*/
	static public function getUserAPIToken($uid){

		$query = new \TaskerMAN\Core\DBQuery("SELECT `api_token`
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

	/**
	 * Formats a JSON response when given data
	 * 
	 * @param mixed $data
	 * @return string response
	*/
	static public function response($data){
		return json_encode(array('status' => 'success', 'response' => $data));
	}

	/**
	 * Formats a JSON response when given an error message
	 *
	 * @param mixed $message
	 * @return string response
	*/
	static public function error($message){
		
		if (!is_array($message)){
			$message = array('message' => $message);
		}

		return json_encode(array('status' => 'error', 'error' => $message));
	}

}