<?php

class IO {
	
	static public function GET($key, $sanitize = true){
		if (!isset($_GET[$key])){
			return null;
		}

		if ($sanitize){
			return self::sanitize(@$_GET[$key]);
		} else {
			return @$_GET[$key];
		}
	}

	static public function POST($key, $sanitize = true){
		if (!isset($_POST[$key])){
			return null;
		}

		if ($sanitize){
			return self::sanitize(@$_POST[$key]);
		} else {
			return @$_POST[$key];
		}
	}

	static public function sanitize($input){
		return htmlentities($input);
	}
}