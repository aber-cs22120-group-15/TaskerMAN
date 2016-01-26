<?php
namespace TaskerMAN\Application;

class UserManagementException extends \Exception {

	public function __construct($message){
		parent::__construct($message);
	}

}