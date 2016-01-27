<?php
namespace TaskerMAN\Application;

/**
 * This class provides an interface to DashboardStats when selecting 
 * statistics for a specific user
 *
 * @author Daniel K Monaghan <dkm2@aber.ac.uk>
 * @version 1.0
*/ 
class UserStats {

	private $uid = null;
	
	/**
	 * Sets the working user id
	 *
	 * @param int $id
	*/
	public function __construct($id){
		$this->uid = $id;
	}

	/**
	 * Returns statistics for the given user 
	 *
	 * @return array
	*/
	public function getStats(){
		return DashboardStats::getStats($this->uid);
	}

}