<?php
namespace TaskerMAN\Core; 

class Install {


	static private $required_tables = array(

		'steps' => "CREATE TABLE IF NOT EXISTS `steps` (
  			`id` int(11) NOT NULL AUTO_INCREMENT,
			  `task_id` int(11) NOT NULL,
			  `title` mediumtext,
			  `comment` mediumtext,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1",

		'tasks' => "CREATE TABLE IF NOT EXISTS `tasks` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `created_uid` int(11) NOT NULL,
			  `created_time` datetime NOT NULL,
			  `assignee_uid` int(11) NOT NULL,
			  `due_by` datetime DEFAULT NULL,
			  `completed_time` datetime DEFAULT NULL,
			  `status` int(1) DEFAULT NULL,
			  `title` varchar(300) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1",

		'users' => "CREATE TABLE IF NOT EXISTS `users` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `email` varchar(300) NOT NULL,
			  `name` varchar(100) NOT NULL,
			  `password` varchar(255) NOT NULL,
			  `admin` int(1) NOT NULL DEFAULT '0',
			  `api_token` varchar(73) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1"

	);

	static public function required(){

		$query = new \DBQuery("SHOW TABLES IN " . Registry::getConfig('DB_DATABASE'));

		$query->execute();

		$tables_in_db = array();
		while ($row = $query->rowNotAssoc()){
			$tables_in_db[] = $row[0];
		}

		foreach (self::$required_tables as $table => $statement){
			if (!in_array($table, $tables_in_db)){
				return true;
			}
		}

		// Count number of users in database

		$query = new \DBQuery("SELECT COUNT(*) AS `NumRows` FROM `users`");
		$query->execute();

		$row = $query->row();

		if ($row['NumRows'] == 0){
			return true;
		}

		return false;
	}

	public function createTables(){

		foreach (self::$required_tables as $statement){

			$query = new \DBQuery($statement);
			$query->execute();

		}

	}

	public function createAdminUser($email, $name, $password){

		return TaskerMAN\UserManagement::create($email, $name, $password);

	}



}