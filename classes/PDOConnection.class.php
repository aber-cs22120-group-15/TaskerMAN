<?php

class PDOConnection {

	public $conn;
	private $error;
	private $query;

	public function __construct($host, $username, $password, $database){

        $dsn = 'mysql:host=' . $host . ';dbname=' . $database;

        $options = array(
            \PDO::ATTR_PERSISTENT => true,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        );

        try {
            $this->conn = new PDO($dsn, $username, $password, $options);
        } catch (Exception $e){
			throw new DBQueryException('FATAL ERROR: Unable to connect to MySQL server!', $e);
        }

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

    public function lastInsertID(){
        return $this->conn->lastInsertId();
    }

}