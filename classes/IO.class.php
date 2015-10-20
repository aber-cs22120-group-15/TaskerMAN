<?php

class IO {

	private $core;

	public function __construct(){
			$this->core = core::getInstance();
	}
	
	public function get($key, $html = true){
		if (isset($_GET[$key])){
			return $this->sanitize(@$_GET[$key], $html);
		} else {
			return null;
		}
	}

	public function post($key, $html = true){
		if (isset($_POST[$key])){
			return $this->sanitize(@$_POST[$key], $html);
		} else {
			return null;
		}
	}

	public function request($key, $html = true){
		if (isset($_REQUEST[$key])){
			return $this->sanitize(@$_REQUEST[$key], $html);
		} else {
			return null;
		}
	}

	public function server($key){
		if (isset($_SERVER[$key])){
			return $this->sanitize(@$_SERVER[$key]);
		} else {
			return null;
		}
	}

	public function cookie_read($key){
		if (isset($_COOKIE[$key])){
			return $this->sanitize(@$_COOKIE[$key]);
		} else {
			return null;
		}
	}

	public function cookie_write($key, $value, $expire = null){
		if (is_null($expire)){
			$expire = time() + 86400 * 365;
		}
		return setcookie($key, $value, $expire, '/');
	}

	public function session_read($key){
		if (isset($_SESSION[$key])){
			return $this->sanitize($_SESSION[$key]);
		} else {
			return null;
		}
	}

	public function session_write($key, $value){
		return $_SESSION[$key] = $value;
	}

	public function sanitize($val, $html = true){

		if (is_array($val)){

			foreach ($val as $k => $v){
				$val[$k] = $this->sanitize($v, $html);
			}

		} else {
			
			if ($html){
				$val = htmlentities($val);
			}
		}

		return $val;
	}

}