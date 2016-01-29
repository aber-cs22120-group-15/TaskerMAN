<?php
namespace TaskerMAN\Core; 

/**
 * Offers a MySQL database connection 
 *
 * @author Daniel K Monaghan <dkm2@aber.ac.uk>
 * @version 1.0
*/ 
class DBConnection {

	public $conn;
	private $error;
	private $query;
	
    /**
     * Initializes a database connection
     * 
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $db
    */
	public function __construct($host, $user, $password, $db){
		$this->connect($host, $user, $password, $db);
	}

    /**
     * Connects to the database server
     * 
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $db
     * @return boolean
     * @throws DBConnectionException
    */
	private function connect ($host, $user, $password, $db){
		
		$dsn = 'mysql:host=' . $host . ';dbname=' . $db;

        $options = array(
            \PDO::ATTR_PERSISTENT => true,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        );

        try {
            $this->conn = new \PDO($dsn, $user, $password, $options);
        } catch (\PDOException $e){
			throw new DBConnectionException($e->getMessage(), $e);
            return false;
		}

		return true;
	}

    /**
     * Begins preperation of a statement
     *
     * @param string $query
     * @return PDOStatement 
    */
	public function prepare($query){
        return $this->conn->prepare($query);
    }

    /**
     * Returns any errors caused by the last run query
     *
     * @return string
    */
    public function getError(){
    	return $this->error;
    }

    /**
     * Begins a MySQL transaction
     *
     * @return boolean
    */
    public function beginTransaction(){
        return $this->conn->beginTransaction();
    }

    /**
     * Commits a MySQL transaction
     *
     * @return boolean
    */
    public function commitTransaction(){
        return $this->conn->commit();
    }

    /**
     * Rolls back a MySQL transaction
     *
     * @return boolean
    */
    public function cancelTransaction(){
        return $this->conn->rollBack();
    }
}