<?php
namespace TaskerMAN;

class TaskListInterfaceException extends \Exception {

	public function __construct($message){
		parent::__construct($message);
	}

}