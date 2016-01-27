<?php
namespace TaskerMAN\Application;

/**
 *
 * @author Daniel K Monaghan <dkm2@aber.ac.uk>
*/
class TaskListInterface {
	

	static public $sort_columns = array('id', 'created_time', 'due_by', 'completed_time', 'status', 'title');
	static private $sort = 'ORDER BY `tasks`.`due_by` ASC';

	static private $tasks = array();

	static private $start_position;
	static private $limit;

	/**
	 * This array holds information about all
	 * possible search constraint options, and their
	 * associated SQL statements and parameters
	*/
	static private $search_criteria = array(

		'assignee_uid' => array(
								'enabled' => false,
								'value' => null,
								'condition' => "`tasks`.`assignee_uid` = :assignee_uid",
								'parameter' => ':assignee_uid'
							),

		'status' => array(
								'enabled' => false,
								'value' => null,
								'condition' => "`tasks`.`status` = :status",
								'parameter' => ':status'
							),

		'title' => array(
								'enabled' => false,
								'value' => null,
								'condition' => "LOWER(`tasks`.`title`) LIKE :title",
								'parameter' => ':title'
							),

		'created_uid' => array(
								'enabled' => false,
								'value' => null,
								'condition' => "`tasks`.`created_uid` = :created_uid",
								'parameter' => ':created_uid'
							)
	);


	/**
	 * Enables one of the preset search criterias 
	 * as defined in self::$search_criteria, and sets
	 * the corresponding value
	 *
	 * @param string $key Criteria Key
	 * @param mixed $value Search value
	 * @throws InventoryException
	 * @return boolean
	*/
	static public function setSearchCriteria($key, $value){

		if (is_null($value)){
			return false;
		}

		if (!isset(self::$search_criteria[$key])){
			throw new TaskListInterfaceException('Unknown search criteria mode ' . $key);
			return false;
		}

		self::$search_criteria[$key]['enabled'] = true;
		self::$search_criteria[$key]['value'] = $value;
	}

	/**
	 * Set starting position for LIMIT
	 * 
	 * @param int $start_position Starting position
	*/
	static public function setStartPosition($start_position){
		self::$start_position = $start_position;
	}

	/**
	 * Set number of items to return
	 * 
	 * @param int $limit Number of items to return
	*/
	static public function setLimit($limit){
		self::$limit = $limit;
	}

	/**
	 * Set sort column
	 *
	 * @param str $column Column name
	 * @param str $direction Ascending/Descending
	 * @return boolean Success
	*/
	static public function setSort($column, $direction){

		$direction = strtoupper($direction);

		if ($direction != 'ASC' && $direction !== 'DESC'){
			return false;
		}

		if (!in_array($column, self::$sort_columns)){
			return false;
		}

		self::$sort = 'ORDER BY `tasks`.`' . $column . '` ' . $direction;

		return true;
	}

	/**
	 * Executes a search on the list of tasks and
	 * returns the tasks
	 *
	 * @return array Array of task data
	*/
	static public function getTasks($objects = false){

		$conditional = self::buildConditional();
		$limit = self::buildLimit();

		$query = new \TaskerMAN\Core\DBQuery("SELECT 
			`tasks`.*,
			`users_assignee`.`name` AS `assignee_name`,
			`users_created`.`name` AS `created_name`

			FROM `tasks`
			JOIN `users` AS `users_assignee` ON `tasks`.`assignee_uid` = `users_assignee`.`id`
			JOIN `users` AS `users_created` ON `tasks`.`created_uid` = `users_created`.`id`

			$conditional

			" . self::$sort . "

			$limit
		");

		// Bind any conditional parameters
		if (!is_null($conditional)){

			foreach (self::$search_criteria as $key => $criteria){
				if ($criteria['enabled']){
					$query->bindValue($criteria['parameter'], $criteria['value']);
				}
			}

		}

		$query->execute();

		if (!$objects){
			return $query->results();
		} else {

			$return = array();

			while ($row = $query->row()){
				$return[$row['id']] = new Task;
				$return[$row['id']]->loadArray($row);
			}

			return $return;
		}
	}

	/**
	 * Builds SQL WHERE statement based on
	 * conditionals defined in the self::$search_criteria
	 *
	 * @return string SQL 
	*/
	static private function buildConditional(){

		$conditions = array();

		foreach (self::$search_criteria as $key => $criteria){
			if (!$criteria['enabled']){
				continue;
			}

			$conditions[] = $criteria['condition'];
		}

		if (empty($conditions)){
			return null;
		} 

		return "WHERE " . implode(" AND ", $conditions);
	}

	/**
	 * Builds SQL LIMIT statement based on
	 * self::$start_position and $limit
	 *
	 * @return string SQL
	*/
	static private function buildLimit(){

		if (is_null(self::$start_position) || is_null(self::$limit)){
			return null;
		}

		return 'LIMIT ' . self::$limit . ' OFFSET ' . self::$start_position;

	}

	/**
	 * Returns total count of tasks in database
	 *
	 * @return int Count
	*/
	static public function getNumTasks(){

		$conditional = self::buildConditional();

		$query = new \TaskerMAN\Core\DBQuery("SELECT
		 	COUNT(*) AS `count`
			FROM `tasks`

			$conditional
		");

		// Bind any conditional parameters
		if (!is_null($conditional)){

			foreach (self::$search_criteria as $key => $criteria){
				if ($criteria['enabled']){
					$query->bindValue($criteria['parameter'], $criteria['value']);
				}
			}

		}

		$query->execute();
		$row = $query->row();

		return $row['count'];
	}

}