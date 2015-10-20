<?php

class PDOQuery {
	
  private $array_as_raw_params = false;

	public function __construct($query){

		$this->core = core::getInstance();
		$this->query = $query;

		try {
   			$this->stmt = $this->core->PDOConnection->prepare($this->query);
   		} catch (PDOException $e){
   			// Fatal query exception
   			throw new DBQueryException('Connection', $e);
   		}

   	}

   	public function bindValue($param, $value, $type = null){

   		// Determine parameter type
	    if (is_null($type)) {
	        switch (true) {
	            case is_int($value):
	                $type = PDO::PARAM_INT;
	                break;
	            case is_bool($value):
	                $type = PDO::PARAM_BOOL;
	                break;
	            case is_null($value):
	                $type = PDO::PARAM_NULL;
	                break;
              case is_array($value):
                  $value = serialize($value);
                  $type = PDO::PARAM_STR;
                  break;
	            default:
	                $type = PDO::PARAM_STR;
	        }
	    }

	    // Bind this value to the statement
	    $this->stmt->bindValue($param, $value, $type);
	  }

    public function execute(){

      $args = func_get_args();

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
    }

    public function results(){
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function row(){
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount(){
    	   return $this->stmt->rowCount();
    }

    public function lastInsertID(){
        return $this->core->PDOConnection->lastInsertId();
    }

    public function setArrayAsRawParams($state){
        $this->array_as_raw_params = $state;
    }

}