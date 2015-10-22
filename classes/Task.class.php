<?php

/*
Status Codes:
	0 = abandoned
	1 = allocated
	2 = completed
*/

class Task {
	
	public $id;
	public $created_uid;
	public $created_time;
	public $assignee_uid;
	public $due_by;
	public $completed_time;
	public $status;
	public $title;

	private $core;

	private $new_task = false;

	public function __construct($id = null){
		$this->core = core::getInstance();

		if (!empty($id)){
			$this->new_task = false;
			$this->load($id);
		} else {
			$this->new_task = true;
		}
	}

	private function load($id){

		$query = new PDOQuery("SELECT `tasks`.*,
			`users_assignee`.`name` AS `assignee_name`,
			`users_created`.`name` AS `created_name`
			
			FROM `tasks`

			JOIN `users` AS `users_assignee` ON `users_assignee`.`id` = `tasks`.`assignee_uid`
			JOIN `users` AS `users_created` ON `users_created`.`id` = `tasks`.`created_uid`

			WHERE `tasks`.`id` = ?
			LIMIT 1
		");

		$query->execute($id);

		if ($query->rowCount() == 0){
			return false;
		}

		$fetch = $query->row();

		$this->id 					= $fetch['id'];
		$this->created_uid 			= $fetch['created_uid'];
		$this->created_name 		= $fetch['created_name'];
		$this->created_time 		= $fetch['created_time'];
		$this->assignee_uid 		= $fetch['assignee_uid'];
		$this->assignee_name 		= $fetch['assignee_name'];
		$this->due_by 				= $fetch['due_by'];
		$this->completed_time 		= $fetch['completed_time'];
		$this->status 				= $fetch['status'];
		$this->title 				= $fetch['title'];

		$query = new PDOQuery("SELECT `id`, `title`
			FROM `steps`
			WHERE `task_id` = ?
		");

		$query->execute($this->id);

		$this->steps = $query->results();
	}

	public function setAssignee($assignee){
		$this->assignee_uid = $assignee;
	}

	public function setDueBy($due_by){
		$this->due_by = $due_by;
	}

	public function setCompletedTime($time = null){
		
		if (is_null($time)){
			$time = date("Y-m-d H:i:s");
		}

		$this->completed_time = $time;
	}

	public function setStatus($status){
		$this->status = $status;
	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function save(){

		if ($this->new_task){

			$stmt = new PDOQuery("INSERT INTO `tasks`
				(`assignee_uid`, `due_by`, `completed_time`, `status`, `title`)
				VALUES
				(:assignee_uid, :due_by, :completed_time, :status, :title)
			");
		} else {

			$stmt = new PDOQuery("UPDATE `tasks` SET
				`assignee_uid` = :assignee_uid,
				`due_by` = :due_by,
				`completed_time` = :completed_time,
				`status` = :status,
				`title`= :title

				WHERE `id` = :id
				LIMIT 1
			");

			$stmt->bindValue(':id', (int) $this->id, PDO::PARAM_INT);
		}

		$stmt->bindValue(':assignee_uid', (int) $this->assignee_uid, PDO::PARAM_INT);
		$stmt->bindValue(':due_by', (string) $this->due_by, PDO::PARAM_STR);
		$stmt->bindValue(':completed_time', (string) $this->completed_time, PDO::PARAM_STR);
		$stmt->bindValue(':status', (int) $this->status, PDO::PARAM_INT);
		$stmt->bindValue(':title', (string) $this->title, PDO::PARAM_STR);
		
		$stmt->execute();

		if ($this->new_task){
			$this->id = $stmt->lastInsertID();
		}

	}
}