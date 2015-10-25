<?php

class TaskListInterface {
	
	private $core;

	// Filtering
	private $statuses 	= null;
	private $user 		= null;

	private $page 		= 1;
	private $per_page 	= 25;

	public function __construct(){

		$this->core = core::getInstance();
	}

	public function setPage($page = 1){

		if (!is_numeric($page) || $page < 0){
			$page = 1;
		}

		$this->page = $page;
		return true;
	}

	public function filterByStatus($statuses){

		if (!is_array($statuses)){
			throw new TaskListInterfaceException('Invalid input to filterByStatus() - not an array');
			return false;
		}

		// Verify statuses are all legal
		foreach ($statuses as $k => $v){
			if ($v > 2 || $v < 0 || !is_numeric($v)){
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

	public function execute(){

		$limit = self::generateLimitConstraint($this->page);
		$where = array();

		// Check if we are filtering by a user
		if ($this->user !== null){
			// Filter by user
			$where[] = "`tasks`.`assignee_uid` = :uid";
		}

		// Check if we are only using selected statuses
		if ($this->statuses !== null){

			$qMarks = str_repeat('?,', count($this->statuses) - 1) . '?';

			$where[] = "`tasks`.`status` IN ($qMarks)";
		}

		if (!empty($where)){
			$where = 'WHERE ' . implode(' AND ', $where);
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
		return $return;
	}
}
