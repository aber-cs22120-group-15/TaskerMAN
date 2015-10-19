<?php

class mysql Extends MySQLi {

	private $config;

	public $query_stack;

	public function __construct($host, $port, $user, $password, $db){
		$this->config = array('host' => $host, 'port' => $port, 'user' => $user, 'password' => $password, 'db' => $db);
		$this->hasFailed = false;
		parent::init();
		$this->initialize();
	}

	public function initialize(){

		$connection = parent::real_connect(
			$this->config['host'],
			$this->config['user'],
			$this->config['password'],
			$this->config['db'],
			$this->config['port']
		);
		
		if (!$connection){
			die('FATAL ERROR: Unable to connect to MySQL server!');
		}

	}

	public function query($query){

		$start = microtime(true);
		// Ping MySQL server, check it's still here. If not, call constructor again.

		if (!parent::ping()){
			$this->connect();
		}

		$result = parent::query($query);
		$time = round(microtime(true) - $start, 5);

		$this->query_stack[] = array('query' => $query, 'time' => $time);

		if ($this->error){

			ob_end_clean();
			ob_start();
			debug_print_backtrace();
			$stackTrace = ob_get_contents();
			ob_end_clean();

			echo '<h2>Fatal error</h2>';
			echo 'A fatal, unexpected error has occurred. <br /><br /><strong>MySQL Error: </strong>' . $this->error . '<br /><br /><strong>Stack trace: </strong><br /><pre>' . $stackTrace . '</pre>';
			exit;

			return false;
		} else {
			return $result;
		}
	}
}