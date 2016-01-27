<?php
namespace TaskerMAN\Core; 

/**
 * Offers a MySQL query object
 *
 * @author Daniel K Monaghan <dkm2@aber.ac.uk>
 * @version 1.0
*/
class DBQuery {
	
	private $conn;
	private $stmt;
	private $query;

	private $array_as_raw_params = false;

	/**
	 * Begins preparing a query
	 *
	 * @param string $query
	 * @throws DBQueryException
	 */
	public function __construct($query){

		$this->conn = Registry::getDatabase();
		$this->query = $query;

		try {
			$this->stmt = $this->conn->prepare($this->query);
		} catch (PDOException $e){
			// Fatal query exception
			throw new DBQueryException($this->query, $e);
		}

	}

	/**
	 * Binds a value to a parameter
	 *
	 * @param string $param
	 * @param mixed $value
	 * @param mixed $type
	 */
	public function bindValue($param, $value, $type = null){

		// Determine parameter type
		if (is_null($type)) {
				switch (true) {
						case is_int($value):
								$type = \PDO::PARAM_INT;
								break;
						case is_bool($value):
								$type = \PDO::PARAM_BOOL;
								break;
						case is_null($value):
								$type = \PDO::PARAM_NULL;
								break;
						case is_array($value):
								$value = serialize($value);
								$type = \PDO::PARAM_STR;
								break;
						default:
								$type = \PDO::PARAM_STR;
				}
		}

		// Bind this value to the statement
		$this->stmt->bindValue($param, $value, $type);
	}

	/**
	 * Executes the query on the server
	 *
	 * @return boolean
	 * @throws DBQueryException
	*/
	public function execute(){

		$args = func_get_args();

		// Check if we want to pass this functions arguments as individual parameters 
		if ($this->array_as_raw_params){

			$temp = array();

			foreach ($args as $v){
				if (is_array($v)){
					$temp = array_merge($temp, $v);
				} else {
					$temp[] = $v;
				}
			}

			$args = $temp;
			
		} else {

			if (!empty($args)){
				foreach ($args as $k => $v){

					if (is_array($v)){
						$args[$k] = serialize($v);
					}

				}
			} else {
				$args = null;
			}
		}

		try {
			return $this->stmt->execute($args);
		} catch (PDOException $e){
			// Fatal query exception
			throw new DBQueryException($this->query, $e);
		}

		return false;
	}

	/**
	 * Returns results of a query
	 *
	 * @return array
	*/
	public function results(){
		return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	/**
	 * Returns a single row
	 *
	 * @return array
	*/
	public function row(){
		return $this->stmt->fetch(\PDO::FETCH_ASSOC);
	}

	/**
	 * Returns a single row without associative keys
	 *
	 * @return array
	*/
	public function rowNotAssoc(){
		return $this->stmt->fetch(\PDO::FETCH_NUM);
	}

	/**
	 * Returns number of results returned by a query
	 *
	 * @return int
	*/
	public function rowCount(){
		return $this->stmt->rowCount();
	}

	/**
	 * Returns last insert ID
	 *
	 * @return int
	*/
	public function lastInsertID(){
		return $this->conn->conn->lastInsertId();
	}

	/**
	 * Set whether or not to treat arguments to execute() as individual parameters
	 *
	 * @param boolean
	*/
	public function setArrayAsRawParams($state){
		$this->array_as_raw_params = $state;
	}

}