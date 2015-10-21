<?php

class UserManagementInvalidEmailException {
	
	public $email;

	public function __construct($email){
		$this->email = $email;
	}

}