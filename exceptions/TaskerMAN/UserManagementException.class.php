<?php
namespace TaskerMAN;

class UserManagementException extends \Exception {

	public function __construct($message){
		parent::__construct($message);
	}

}