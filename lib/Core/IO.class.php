<?php
namespace TaskerMAN\Core; 

/**
 * Handles all user I/O
 *
 * @author Daniel K Monaghan <dkm2@aber.ac.uk>
 * @version 1.0
*/
class IO {
	
	/**
	 * Returns value of given GET parameter with optional sanitization
	 *
	 * @param string $key
	 * @param boolean $sanitize
	 * @return mixed 
	*/
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

	/**
	 * Returns value of given POST parameter with optional sanitization
	 *
	 * @param string $key
	 * @param boolean $sanitize
	 * @return mixed 
	*/
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

	/**
	 * Sanitizes input by filtering out HTML entities
	 *
	 * @param string $input
	 * @return string
	*/
	static public function sanitize($input){
		return htmlentities($input);
	}
}