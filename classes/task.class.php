<?php

class task {
	
	public $id;
	public $created_uid;
	public $created_time;
	public $assignee_uid;
	public $due_by;
	public $completed_time;
	public $status;
	public $title;
	public $details;

	private $core;

	public function __construct($id){
		$this->id = $id;
		$this->core = core::getInstance();
		$this->load();
	}

	private function load(){

		$query = $this->core->db->query("SELECT *
			FROM `tasks`
			WHERE `id` = '$this->id'
			LIMIT 1
		");

		$fetch = $query->fetch_assoc();

		$this->created_uid 		= $fetch['created_uid'];
		$this->created_time 	= $fetch['created_time'];
		$this->assignee_uid 	= $fetch['assignee_uid'];
		$this->due_by 			= $fetch['due_by'];
		$this->completed_time 	= $fetch['completed_time'];
		$this->status 			= $fetch['status'];
		$this->title 			= $fetch['title'];
		$this->details 			= $fetch['details'];
	}
}