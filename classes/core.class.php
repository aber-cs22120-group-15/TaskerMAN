<?php

class core {

	private $objects = null;
	private static $instance = null;

	private function __construct(){}
	private function __clone(){}

	public static function getInstance(){
		if (self::$instance === null){
			self::$instance = new core();
		}
		return self::$instance;
	}

	public function __set($key, $val) {
		$this->objects[$key] = $val;
	}

	public function __get($key) {
		return $this->objects[$key];
	}

}