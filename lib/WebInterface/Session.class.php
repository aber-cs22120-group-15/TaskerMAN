<?php
namespace WebInterface;

use IO;

class Session {
	
	static public function init(){
		session_start();
	}

	static public function destroy(){
		session_destroy();
	}

	static public function get($key){
		if (isset($_SESSION[$key])){
			return IO::sanitize($_SESSION[$key]);
		} else {
			return null;
		}
	}

	static public function set($key, $value){
		$_SESSION[$key] = IO::sanitize($value);
		return true;
	}

	static public function isLoggedIn(){
		return isset($_SESSION['uid']);
	}

}