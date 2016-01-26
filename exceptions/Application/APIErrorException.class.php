<?php

namespace TaskerMAN\Application;

class APIErrorException extends \Exception {
	
	public function __construct($message){
		parent::__construct($message);
	}

}