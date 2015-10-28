<?php

class DBConnection {

	public $conn;
	private $error;
	private $query;
	
	public function __construct($host, $user, $password, $db){

		$this->connect($host, $user, $password, $db);
	}

	private function connect ($host, $user, $password, $db){
		
		$dsn = 'mysql:host=' . $host . ';dbname=' . $db;

        $options = array(
            \PDO::ATTR_PERSISTENT => true,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        );

        try {
            $this->conn = new \PDO($dsn, $user, $password, $options);
        } catch (Exception $e){
			throw new DBConnectionException($e->getMessage());
		}

		return true;
	}

	public function prepare($query){
        return $this->conn->prepare($query);
    }

    public function getError(){
    	return $this->error;
    }

    public function beginTransaction(){
        return $this->conn->beginTransaction();
    }

    public function commitTransaction(){
        return $this->conn->commit();
    }

    public function cancelTransaction(){
        return $this->conn->rollBack();
    }
}