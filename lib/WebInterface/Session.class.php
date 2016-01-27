<?php
namespace TaskerMAN\WebInterface;
use \TaskerMAN\Core\IO;

/**
 * Handles user sessions
 *
 * @author Daniel K Monaghan <dkm2@aber.ac.uk>
 * @version 1.0
*/ 
class Session {
	
	/**
	 * Begins the session
	*/
	static public function init(){
		session_start();
	}

	/**
	 * Destroys the session
	*/
	static public function destroy(){
		session_destroy();
	}

	/** 
	 * Returns a session variable given a key
	 *
	 * @param string $key
	 * @return mixed
	*/
	static public function get($key){
		if (isset($_SESSION[$key])){
			return IO::sanitize($_SESSION[$key]);
		} else {
			return null;
		}
	}

	/**
	 * Set a session variable to a given value
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return boolean
	*/
	static public function set($key, $value){
		$_SESSION[$key] = IO::sanitize($value);
		return true;
	}

	/**
	 * Checks whether or not the user is logged in
	 * 
	 * @return boolean
	*/
	static public function isLoggedIn(){
		return isset($_SESSION['uid']);
	}

}