<?php

class Session {
	

	public  $user = null;
	private $session_id;
	private $core;

	public function __construct(){

		$this->core = core::getInstance();

		session_start();
		$this->session_id = session_id();
		
		$uid = $this->get('uid');
		if (!empty($uid)){
			$this->user = new User($uid);
		}

	}

	public function set($key, $value){
		return $this->core->IO->session_write($key, $value);
	}

	public function get($key){
		return $this->core->IO->session_read($key);
	}

	public function isLoggedIn(){
		return !is_null($this->user);
	}

	public function logout(){
		session_destroy();
	}
}