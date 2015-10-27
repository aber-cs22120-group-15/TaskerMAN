<?php

class WebInterface {
	
	static public $page;
	static private $ob;

	static public $title;

	static private $showTemplate = true;

	static private $core;

	static public function init(){

		self::$core = core::getInstance();

		Session::init();

		self::$page = preg_replace("/[^A-Za-z0-9_ ]/", '', self::$core->IO->get('p'));
		self::enforceLogin();
		self::validatePage();
		self::execute();
	}

	static private function enforceLogin(){

		if (is_null(Session::$user) && self::$page !== 'login'){
			header('Location: index.php?p=login');
			exit;
		}

	}

	static private function validatePage(){
		if (empty(self::$page)){
			self::$page = 'main';
			return true;
		} elseif (!file_exists('pages/' . self::$page . '.php')){
			self::$page = '404';
			return false;
		}

		return true;
	}

	static private function execute(){

		ob_start();
		require_once('pages/' . self::$page . '.php');
		self::$ob = ob_get_contents();
		ob_end_clean();

		if (self::$showTemplate){
			require_once('template/header.php');
		}

		echo self::$ob;
		
		if (self::$showTemplate){
			require_once('template/footer.php');
		}
	}

	static public function setTitle($title){
		self::$title = $title;
	}

	static public function showTemplate($bool){
		self::$showTemplate = $bool;
	}

}