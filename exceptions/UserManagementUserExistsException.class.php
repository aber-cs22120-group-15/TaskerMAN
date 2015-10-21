<?php

class UserManagementUserExistsException {
	
	public $email;

	public function __construct($email){
		$this->email = $email;
	}

}