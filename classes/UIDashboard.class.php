<?php

class UIDashboard {
	
	private $core;

	public $stats;

	public function __construct(){
		
		$this->core = core::getInstance();
		$this->loadStats();
	}

	private function loadStats(){

		$query = new PDOQuery("SELECT

			(
				SELECT COUNT(*)
				FROM `tasks`
				WHERE `tasks`.`status` = 1
			) AS `outstanding`,

			(
				SELECT COUNT(*)
				FROM `tasks`
				WHERE `tasks`.`status` = 1
				AND NOW() > `tasks`.`due_by`
			) AS `overdue`,

			(
				(
					(
						SELECT COUNT(*)
						FROM `tasks`
						WHERE `tasks`.`status` = 2
						AND `tasks`.`due_by` > `tasks`.`completed_time`
					) 
					/
					(
						SELECT COUNT(*)
						FROM `tasks`
						WHERE `tasks`.`status` = 2
					)
				) * 100
			) AS `percent_on_time`
		");

		$query->execute();

		$this->stats = $query->row();

	}



}