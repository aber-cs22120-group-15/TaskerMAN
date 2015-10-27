<?php

class Session {
	

	static public  $user = null;
	static private $session_id;
	static private $core;

	static public function init(){

		self::$core = core::getInstance();

		session_start();
		self::$session_id = session_id();
		
		$uid = self::get('uid');
		if (!empty($uid)){
			self::$user = new User($uid);
		}

	}

	static public function set($key, $value){
		return IO::session_write($key, $value);
	}

	static public function get($key){
		return IO::session_read($key);
	}

	static public function isLoggedIn(){
		return !is_null(self::$user);
	}

	static public function logout(){
		session_destroy();
	}
}