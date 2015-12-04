<?php
namespace TaskerMAN;

/**
 *
 * @author Daniel K Monaghan <dkm2@aber.ac.uk>
*/
class UserListInterface {
	

	static public $sort_columns = array('id', 'email', 'name');
	static private $sort = 'ORDER BY `users`.`name` ASC';

	static private $users = array();

	static private $start_position;
	static private $limit;

	/**
	 * This array holds information about all
	 * possible search constraint options, and their
	 * associated SQL statements and parameters
	*/
	static private $search_criteria = array(

		'name' => array(
								'enabled' => false,
								'value' => null,
								'condition' => "`LOWER(`users`.`name`) LIKE :name",
								'parameter' => ':name'
							),
		'email' => array(
								'enabled' => false,
								'value' => null,
								'condition' => "`LOWER(`users`.`email`) LIKE :email",
								'parameter' => ':email'
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

		if (empty($value)){
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

		self::$sort = 'ORDER BY `users`.`' . $column . '` ' . $direction;
		return true;
	}

	/**
	 * Executes a search on the list of users and
	 * returns the users
	 *
	 * @return array Array of users
	*/
	static public function getUsers(){

		$conditional = self::buildConditional();
		$limit = self::buildLimit();

		$query = new \DBQuery("SELECT 
			`users`.`id`,
			`users`.`name`,
			`users`.`email`,
			`users`.`admin`

			FROM `users`

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

		return $query->results();
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
	 * Returns total count of users in database
	 *
	 * @return int Count
	*/
	static public function getNumUsers(){

		$conditional = self::buildConditional();

		$query = new \DBQuery("SELECT
		 	COUNT(*) AS `count`
			FROM `users`

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