<?php
namespace TaskerMAN\Core; 

class Registry {
	
	private static $config;
	private static $db;

	static public function loadConfig($config){
		
		self::$config = $config;
	}

	// Database
	static private function initDatabase(){

		if (self::$db !== null){
			return false;
		}

		try {
			self::$db = new DBConnection(self::$config['DB_HOST'], self::$config['DB_USERNAME'], self::$config['DB_PASSWORD'], self::$config['DB_DATABASE']);
		} catch (DBConnectionException $e){
			throw new FatalException('Unable to connect to database', $e);
		}
	}

	static public function getDatabase(){

        self::initDatabase();
        return self::$db;
    }

    static public function getConfig($key){

    	if (!isset(self::$config[$key])){
    		return null;
    	} else {
    		return self::$config[$key];
    	}
    }

}