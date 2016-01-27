<?php
namespace TaskerMAN\WebInterface;
use \TaskerMAN\Core\IO;

/**
 * Handles templating for the web interface
 *
 * @author Daniel K Monaghan <dkm2@aber.ac.uk>
 * @version 1.0
*/ 
class WebInterface {
	
	static public $page;
	static private $ob;

	static public $title;

	static private $showTemplate = true;

	static public $user = null;

	/** 
	 * Initalizes the web interface by enforcing logins, validating that the page
	 * that's requested exists and that the user has permission to view it, then
	 * loads the user's information, then finally executes the page
	*/
	static public function init(){

		Session::init();

		self::$page = preg_replace("/[^A-Za-z0-9_ ]/", '', IO::GET('p'));
		self::enforceLogin();
		self::validatePage();
		self::loadLoggedInUser();
		self::execute();
	}

	/**
	 * Enforces login by redirecting the user to the login page if they
	 * access a page they don't have permission to view
	*/
	static private function enforceLogin(){

		if (self::$page !== 'login' && self::$page !== 'install' && self::$page !== '404' && !Session::isLoggedIn()){
			header('Location: index.php?p=login');
			exit;
		}
	}

	/**
	 * Confirms that the requested page exists
	 *
	 * @return boolean
	 * @throws FatalException
	*/
	static private function validatePage(){

		if (empty(self::$page)){
			self::$page = 'main';
			return true;
		} elseif (!file_exists('pages/' . self::$page . '.php')){
			throw new \TaskerMAN\Core\FatalException('404 - Page Not Found', new \Exception('Requested page ('  . self::$page . ') was not found'));
			return false;
		}

		return true;
	}

	/**
	 * Loads the logged in user's data into the session
	 *
	 * @return boolean 
	 */
	static private function loadLoggedInUser(){

		if (!Session::isLoggedIn()){
			return false;
		}

		self::$user = new \TaskerMAN\Application\User(Session::get('uid'));
		return true;
	}

	/**
	 * Executes the requested page
	*/
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

	/**
	 * Sets page title
	 * 
	 * @param string $title
	*/
	static public function setTitle($title){
		self::$title = $title;
	}

	/**
	 * Toggles templating 
	 *
	 * @param boolean
	*/
	static public function showTemplate($bool){
		self::$showTemplate = $bool;
	}

}