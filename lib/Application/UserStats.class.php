<?php
namespace TaskerMAN\Application;

class UserStats {

	private $uid = null;
	
	public function __construct($id){
		$this->uid = $id;
	}

	public function getStats(){
		
		$row = DashboardStats::getStats($this->uid);

		return $row;
	}

}