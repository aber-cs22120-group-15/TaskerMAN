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

	public function __construct($id = null){
		$this->core = core::getInstance();

		if (!empty($id)){
			$this->load($id);
		}
	}

	private function load($id){

		$query = new PDOQuery("SELECT *
			FROM `tasks`
			WHERE `id` = ?
			LIMIT 1
		");

		$query->execute($id);

		if ($query->rowCount() == 0){
			return false;
		}

		$fetch = $query->row();

		$this->id 				= $fetch['id'];
		$this->created_uid 		= $fetch['created_uid'];
		$this->created_time 	= $fetch['created_time'];
		$this->assignee_uid 	= $fetch['assignee_uid'];
		$this->due_by 			= $fetch['due_by'];
		$this->completed_time 	= $fetch['completed_time'];
		$this->status 			= $fetch['status'];
		$this->title 			= $fetch['title'];
		$this->details 			= $fetch['details'];
	}

	public function setAssignee($assignee){
		$this->assignee_uid = $assignee;
	}

	public function setDueBy($due_by){
		$this->due_by = $due_by;
	}

	public function complete(){
		$this->completed_time = date("Y-m-d H:i:s");
		$this->status = 1;
	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function setDetails($details){
		$this->details = $details;
	}

	public function save(){

		$stmt = new PDOQuery("INSERT INTO `tasks`
			(`assignee_uid`, `due_by`, `completed_time`, `status`, `title`, `details`)
			VALUES
			(:assignee_uid, :due_by, :completed_time, :status, :title, :details)

			ON DUPLICATE KEY UPDATE 
			`assignee_uid` = :assignee_uid,
			`due_by` = :due_by,
			`completed_time` = :completed_time,
			`status` = :status,
			`title`= :title,
			`details` = :details

			WHERE `id` = :id
			LIMIT 1
		");

		$stmt->bindValue(':id', (int) $this->id, PDO::PARAM_INT);
		$stmt->bindValue(':assignee_uid', (int) $this->assignee_uid, PDO::PARAM_INT);
		$stmt->bindValue(':due_by', (string) $this->due_by, PDO::PARAM_STR);
		$stmt->bindValue(':completed_time', (string) $this->completed_time, PDO::PARAM_STR);
		$stmt->bindValue(':status', (int) $this->status, PDO::PARAM_INT);
		$stmt->bindValue(':title', (string) $this->title, PDO::PARAM_STR);
		$stmt->bindValue(':details', (string) $this->details, PDO::PARAM_STR);

		$stmt->execute();

	}
}