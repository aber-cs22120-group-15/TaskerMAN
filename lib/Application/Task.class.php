<?php
namespace TaskerMAN\Application;

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

	/**
	 * Initializes the task object if given a task id
	 *
	 * @param int $id
	*/
	public function __construct($id = null){

		if (!empty($id)){
			$this->new_task = false;
			$this->load($id);
		} else {
			$this->new_task = true;
		}
	}

	/**
	 * Loads task details from the database into the object
	 *
	 * @param int $id
	 * @return boolean
	*/
	private function load($id){

		$query = new \TaskerMAN\Core\DBQuery("SELECT `tasks`.*,
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

	/**
	 * Loads task data into this object when passed
	 * an array of data
	 *
	 * @param array $fetch
	*/
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

	/**
	 * Returns an array of steps associated with this task
	 *
	 * @return array $steps
	*/
	public function getSteps(){

		if (!empty($this->steps)){
			return $this->steps;
		}

		$query = new \TaskerMAN\Core\DBQuery("SELECT `id`, `title`, `comment`
			FROM `steps`
			WHERE `task_id` = ?
		");

		$query->execute($this->id);

		$this->steps = $query->results();

		return $this->steps;
	}

	/**
	 * Checks if this task is overdue
	 *
	 * @return boolean
	*/
	public function isOverdue(){
		return (time() > strtotime($this->due_by));
	}

	/**
	 * Checks if this task was completed after its due date
	 *
	 * @return boolean
	*/
	public function completedLate(){
		if ($this->status != 2){
			return false;
		}

		return (strtotime($this->completed_time) > strtotime($this->due_by));
	}

	/**
	 * Checks if this task is due in the next 24 hours
	 *
	 * @return boolean
	*/
	public function dueSoon(){
		return ((time() + self::ONE_DAY_IN_SECONDS) > strtotime($this->due_by));
	}

	/**
	 * Sets the ID for this task
	 * 
	 * @param int $id
	*/
	public function setID($id){
		$this->id = $id;
		$this->new_task = false;
	}

	/**
	 * Sets the creator's UID for this task
	 *
	 * @param int $uid
	*/
	public function setCreatedByUser($uid){
		$this->created_uid = $uid;
	}

	/**
	 * Sets the assignee's UID for this task
	 *
	 * @param int $uid
	*/
	public function setAssignee($uid){
		$this->assignee_uid = $uid;
	}

	/**
 	 * Sets the due by date for this task
 	 *
 	 * @param string $due_by
 	 * @return boolean
 	 * @throws TaskException
 	*/
	public function setDueBy($due_by){

		// Validate date
		if (!self::validateDate($due_by)){
			throw new TaskException('Inputted due date is not valid');
			return false;
		}

		$this->due_by = $due_by;
		return true;
	}

	/**
	 * Sets the time this task was completed
	 * 
	 * @param string $time
	*/
	public function setCompletedTime($time = null){
		
		if (is_null($time)){
			$time = date("Y-m-d H:i:s");
		}

		$this->completed_time = $time;
	}

	/**
	 * Validates wether or not a given date is valid 
	 * 
	 * @param string $date
	 * @return boolean
	*/
	public function validateDate($date){

	    $date_object = \DateTime::createFromFormat('Y-m-d', $date);
	    return $date_object && $date_object->format('Y-m-d') == $date;
	}

	/**
	 * Sets the status for this task
	 * 
	 * @param int $status
	*/
	public function setStatus($status){
		$this->status = $status;
	}

	/**
	 * Sets the title for this task
	 * 
	 * @param string $title
	 * @return boolean
	 * @throws TaskException
	*/
	public function setTitle($title){
		$title = trim($title);

		if (empty($title)){
			throw new TaskException('Task title cannot be empty');
			return false;
		}

		$this->title = $title;
		return true;
	}

	/**
	 * Adds a new step to the task
	 * 
	 * @param string $title
	 * @param string $comment
	 * @return boolean
	 * @throws TaskException
	*/
	public function createStep($title, $comment = null){

		if (empty($title)){
			throw new TaskException('Task Step title cannot be blank');
			return false;
		}

		/*
		If this is a new task without a database entry yet,
		save the step locally in an array, ready to be committed
		once the task has a database id
		*/
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

	/**
	 * If this is a new task, it will not have yet been assigned a task ID up until this
	 * point. Once the task has been saved to the database and an ID assigned, this function
	 * can then be run to save all the steps to the database.
	 */
	private function buildSteps(){

		foreach ($this->temp_steps as $step){
			$this->createStep($step['title'], $step['comment']);
		}

		$this->temp_steps = array();
	}

	/**
	 * Saves the task object to the database, also triggers buildSteps() if
	 * this is a new task.
	 *
	 * @return boolean
	 * @throws TaskException
	*/
	public function save(){

		// Check if task is new. If so, INSERT query is run
		if ($this->new_task){

			if (empty($this->temp_steps)){
				// Each task must have at least one step associated with it
				throw new TaskException('Task creation requires at least one associated step');
				return false;
			}

			$stmt = new \TaskerMAN\Core\DBQuery("INSERT INTO `tasks`
				(`created_uid`, `created_time`, `assignee_uid`, `due_by`, `completed_time`, `status`, `title`)
				VALUES
				(:created_uid, NOW(), :assignee_uid, :due_by, :completed_time, :status, :title)
			");
			
		} else {

			$stmt = new \TaskerMAN\Core\DBQuery("UPDATE `tasks` SET
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

		// Bind variables
		$stmt->bindValue(':created_uid', (int) $this->created_uid, \PDO::PARAM_INT);
		$stmt->bindValue(':assignee_uid', (int) $this->assignee_uid, \PDO::PARAM_INT);
		$stmt->bindValue(':due_by', (string) $this->due_by, \PDO::PARAM_STR);
		$stmt->bindValue(':completed_time', (string) $this->completed_time, \PDO::PARAM_STR);
		$stmt->bindValue(':status', (int) $this->status, \PDO::PARAM_INT);
		$stmt->bindValue(':title', (string) $this->title, \PDO::PARAM_STR);
		
		$stmt->execute();

		// If this is a new task, run buildSteps()
		if ($this->new_task){
			$this->id = $stmt->lastInsertID();
			$this->new_task = false;
			$this->buildSteps();
		}

	}
}