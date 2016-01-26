<?php
namespace TaskerMAN\Application;

class TaskException extends \Exception {

	public function __construct($message){
		parent::__construct($message);
	}
}

