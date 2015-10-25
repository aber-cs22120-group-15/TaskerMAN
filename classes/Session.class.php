<?php

class Session {
	

	public  $uid = null;
	private $session_id;
	private $core;

	public function __construct(){

		$this->core = core::getInstance();

		session_start();
		$this->session_id = session_id();
		
		$uid = self::get('uid');
		if (!empty($uid)){
			$this->uid = $uid;
		}

	}

	public function set($key, $value){
		return $this->core->IO->session_write($key, $value);
	}

	public function get($key){
		return $this->core->IO->session_read($key);
	}

	public function isLoggedIn(){
		return !is_null($this->uid);
	}

	public function logout(){
		session_destroy();
	}
}