<?php
namespace TaskerMAN\Core; 

/**
 * The registry is a globally accessible 
 *
 * @author Daniel K Monaghan <dkm2@aber.ac.uk>
 * @version 1.0
*/
class Registry {
	
	private static $config;
	private static $db;

	/**
	 * Loads a given config array statically into 
	 * the Registry object
	 *
	 * @param array $config
	*/
	static public function loadConfig($config){
		self::$config = $config;
	}

	/**
	 * Initializes a database connection
	 *
	 * @return boolean
	 * @throws FatalException
	*/
	static private function initDatabase(){

		if (self::$db !== null){
			return false;
		}

		try {
			self::$db = new DBConnection(self::$config['DB_HOST'], self::$config['DB_USERNAME'], self::$config['DB_PASSWORD'], self::$config['DB_DATABASE']);
		} catch (DBConnectionException $e){
			throw new FatalException('Unable to connect to database', $e);
		}

		return true;
	}

	/**
	 * Returns a reference to the static database object
	 * 
	 * @return DBConnection
	*/
	static public function getDatabase(){
        self::initDatabase();
        return self::$db;
    }

    /**
     * Returns a configuration value
     *
     * @param string $key
     * @return mixed
    */
    static public function getConfig($key){
    	
    	if (!isset(self::$config[$key])){
    		return null;
    	} else {
    		return self::$config[$key];
    	}
    }

}