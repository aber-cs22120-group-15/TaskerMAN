<?php

class user_tasks {

	private $uid;
	private $core;

	public function __construct($uid){
		$this->uid = $uid;
		$this->core = core::getInstance();
	}
	
	public function get($limit = 25, $start = 0){

		$query = new PDOQuery("SELECT `tasks`.*,
			`users_assignee`.`username` AS `assignee_username`,
			`users_created`.`username` AS `created_username`

			FROM `tasks`
			
			JOIN `users` AS `users_assignee` ON `users_assignee`.`id` = `tasks`.`assignee_uid`
			JOIN `users` AS `users_created` ON `users_created`.`id` = `tasks`.`created_uid`
			
			WHERE `tasks`.`assignee_uid` = :uid
			LIMIT :start, :limit
		");

		$query->bindValue(':uid', 	(int) $this->uid, PDO::PARAM_INT);
		$query->bindValue(':start', (int) $start, PDO::PARAM_INT);
		$query->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
		$query->execute();

		return $query->results();
	}

}