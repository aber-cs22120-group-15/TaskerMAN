<?php

class DBConnectionException extends FatalException {
	
	public function __construct($error, $e){
		parent::__construct('Unable to connect to database', $e);
		parent::setExtraHTML('<strong>Error Message: </strong> ' . $error);
	}

}