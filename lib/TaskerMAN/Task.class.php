<?php
namespace TaskerMAN;

/*
Status Codes:
	0 = abandoned
	1 = allocated
	2 = completed
*/

class Task {
	
	public $id;
	public $created_uid;
	public $created_name;
	public $created_time;
	public $assignee_uid;
	public $assignee_name;
	public $due_by;
	public $completed_time;
	public $status;
	public $title;
	public $steps;

	private $new_task = false;
	private $temp_steps;

	const ONE_DAY_IN_SECONDS = 86400;

	public function __construct($id = null){
	
		if (!empty($id)){
			$this->new_task = false;
			$this->load($id);
		} else {
			$this->new_task = true;
		}
	}

	private function load($id){

		$query = new \DBQuery("SELECT `tasks`.*,
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
	}

	public function loadArray($fetch){
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
		$this->new_task 			= false;
	}

	public function getSteps(){

		if (!empty($this->steps)){
			return $this->steps;
		}

		$query = new \DBQuery("SELECT `id`, `title`
			FROM `steps`
			WHERE `task_id` = ?
		");

		$query->execute($this->id);

		$this->steps = $query->results();

		return $this->steps;
	}

	public function isOverdue(){
		return (time() > strtotime($this->due_by));
	}

	public function completedLate(){
		if ($this->status != 2){
			return false;
		}

		return (strtotime($this->completed_time) > strtotime($this->due_by));
	}

	public function dueSoon(){
		return ((time() + self::ONE_DAY_IN_SECONDS) > strtotime($this->due_by));
	}

	public function setID($id){
		$this->id = $id;
		$this->new_task = false;
	}

	public function setCreatedByUser($uid){
		$this->created_uid = $uid;
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

	public function createStep($title, $comment){

		if ($this->new_task){

			$this->temp_steps[] = array('title' => $title, 'comment' => $comment);
			return true;
		} else {

			// Create step object now
			$step = new TaskStep();
			$step->setTitle($title);
			$step->setComment($comment);
			$step->setTaskID($this->id);
			$step->save();

			$this->steps[] = $step->id;
			return $step->id;
		}

	}

	private function buildSteps(){

		foreach ($this->temp_steps as $step){
			$this->createStep($step['title'], $step['comment']);
		}

		$this->temp_steps = array();
	}

	public function save(){

		if ($this->new_task){

			if (empty($this->temp_steps)){
				// Each task must have at least one step associated with it
				throw new TaskException('Task creation requires at least one associated step');
				return false;
			}

			$stmt = new \DBQuery("INSERT INTO `tasks`
				(`created_uid`, `created_time`, `assignee_uid`, `due_by`, `completed_time`, `status`, `title`)
				VALUES
				(:created_uid, NOW(), :assignee_uid, :due_by, :completed_time, :status, :title)
			");
			
		} else {

			$stmt = new \DBQuery("UPDATE `tasks` SET
				`created_uid` = :created_uid,
				`assignee_uid` = :assignee_uid,
				`due_by` = :due_by,
				`completed_time` = :completed_time,
				`status` = :status,
				`title`= :title

				WHERE `id` = :id
				LIMIT 1
			");

			$stmt->bindValue(':id', (int) $this->id, \PDO::PARAM_INT);
		}

		$stmt->bindValue(':created_uid', (int) $this->created_uid, \PDO::PARAM_INT);
		$stmt->bindValue(':assignee_uid', (int) $this->assignee_uid, \PDO::PARAM_INT);
		$stmt->bindValue(':due_by', (string) $this->due_by, \PDO::PARAM_STR);
		$stmt->bindValue(':completed_time', (string) $this->completed_time, \PDO::PARAM_STR);
		$stmt->bindValue(':status', (int) $this->status, \PDO::PARAM_INT);
		$stmt->bindValue(':title', (string) $this->title, \PDO::PARAM_STR);
		
		$stmt->execute();

		if ($this->new_task){
			$this->id = $stmt->lastInsertID();
			$this->new_task = false;
			$this->buildSteps();
		}

	}
}