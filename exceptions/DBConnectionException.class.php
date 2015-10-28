<?php

class DBConnectionException extends Exception {
	
	public function __construct($error){
		parent::__construct('Unable to connect to database - ' . $error);
	}

}