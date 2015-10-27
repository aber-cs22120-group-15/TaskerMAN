<?php

class IO {
	
	static public function GET($key){
		if (!isset($_GET[$key])){
			return null;
		}

		return self::sanitize($_GET[$key]);
	}

	static public function POST($key){
		if (!isset($_POST[$key])){
			return null;
		}

		return self::sanitize(@$_POST[$key]);
	}

	static public function session_read($key){
		if (!isset($_SESSION[$key])){
			return null;
		} else {
			return $_SESSION[$key];
		}
	}

	static public function session_write($key, $value){
		$_SESSION[$key] = self::sanitize($value);
	}

	static public function sanitize($input){
		return htmlentities($input);
	}
}