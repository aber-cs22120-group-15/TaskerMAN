<?php

class TaskListInterface {
	
	private $core;

	// Filtering
	private $statuses 	= null;
	private $user 		= null;

	private $per_page 	= 25;

	public function __construct(){

		$this->core = core::getInstance();
	}

	public function filterByStatus($statuses){

		// Verify statuses are all legal
		foreach ($statuses as $k => $v){
			if ($v > 2 || $v < 0){
				throw new TaskListInterfaceException('Invalid status filter ' . $v);
				return false;
			}
		}

		$this->statuses = $statuses;

		return true;
	}

	public function filterByUser($uid){
		$this->user = (int) $uid;
	}

	public function execute($page = null){

		$limit = self::generateLimitConstraint($page);
		$where = array();

		// Check if we are filtering by a user
		if ($this->user !== null){
			// Filter by user
			$where[] = "`tasks`.`assigned_uid` = :uid";
		}

		// Check if we are only using selected statuses
		if ($this->statuses !== null){

			$qMarks = str_repeat('?,', count($this->statuses) - 1) . '?';

			$where[] = "`tasks`.`status` IN ($qmarks)";
		}

		if (!empty($where)){
			$where = implode(' AND ', $where);
		} else {
			$where = null;
		}

		$query = new PDOQuery("SELECT
			`tasks`.*,
			`users`.`name`

			FROM `tasks`
			JOIN `users` ON `tasks`.`assignee_uid` = `users`.`id`

			$where

			ORDER BY `tasks`.`due_by` DESC
			LIMIT $limit->start, $limit->end
		");


		if ($this->user !== null){
			$query->bindValue(':uid', $this->user);
		}

		if ($this->statuses !== null){
			$query->setArrayAsRawParams(true);
			$query->execute($this->statuses);
		} else {
			$query->execute();
		}

		return $query->results();
	}

	// TODO: Implement this function to work dynamically

	private function generateLimitConstraint($page = null){

		if (is_null($page)){
			$page = 1;
		}

		$return = new stdClass();
		$return->start = ($page - 1) * $this->per_page;
		$return->end = $this->per_page;
		var_dump($return);

		return $return;
	}
}
