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

	static public function sanitize($input){
		return htmlentities($input);
	}
}