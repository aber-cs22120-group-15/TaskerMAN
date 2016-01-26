<?php
namespace TaskerMAN\Application;

class TaskListInterfaceException extends \Exception {

	public function __construct($message){
		parent::__construct($message);
	}

}