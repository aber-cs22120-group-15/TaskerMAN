<?php
namespace TaskerMAN\WebInterface;

use \TaskerMAN\Core\IO;

class WebInterface {
	
	static public $page;
	static private $ob;

	static public $title;

	static private $showTemplate = true;

	static public $user = null;

	static public function init(){

		Session::init();

		self::$page = preg_replace("/[^A-Za-z0-9_ ]/", '', IO::GET('p'));
		self::enforceLogin();
		self::validatePage();
		self::loadLoggedInUser();
		self::execute();
	}

	static private function enforceLogin(){

		if (self::$page !== 'login' && self::$page !== 'install' && self::$page !== '404' && !Session::isLoggedIn()){
			header('Location: index.php?p=login');
			exit;
		}
	}

	static private function validatePage(){
		if (empty(self::$page)){
			self::$page = 'main';
			return true;
		} elseif (!file_exists('pages/' . self::$page . '.php')){
			throw new \FatalException('404 - Page Not Found', new \Exception('Requested page ('  . self::$page . ') was not found'));
			return false;
		}

		return true;
	}

	static private function loadLoggedInUser(){
		if (!Session::isLoggedIn()){
			return false;
		}

		self::$user = new \TaskerMAN\Application\User(Session::get('uid'));
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