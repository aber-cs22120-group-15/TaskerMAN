<?php
namespace TaskerMAN;

class DashboardStats {
	
	static public function getStats($uid = null){

		if (!is_null($uid)){
			$where = ' AND `assignee_uid` = :uid';
		} else {
			$where = null;
		}

		$query = new \DBQuery("SELECT

			(
				SELECT COUNT(*)
				FROM `tasks`
				WHERE `status` <> 0
				$where
			) AS `total`,

			(
				SELECT COUNT(*)
				FROM `tasks`
				WHERE `tasks`.`status` = 1
				$where
			) AS `outstanding`,

			(
				SELECT COUNT(*)
				FROM `tasks`
				WHERE `tasks`.`status` = 1
				AND `tasks`.`due_by` BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 1 WEEK)
				$where
			) AS `due_in_week`,

			(
				SELECT COUNT(*)
				FROM `tasks`
				WHERE `tasks`.`status` = 1
				AND NOW() > `tasks`.`due_by`
				$where
			) AS `overdue`,

			(
				SELECT COUNT(*)
				FROM `tasks`
				WHERE `tasks`.`status` = 2
				$where
			) AS `completed`,

			(
				SELECT COUNT(*)
				FROM `tasks`
				WHERE `tasks`.`status` = 2
				AND `tasks`.`due_by` <= `tasks`.`completed_time`
				$where
			) AS `completed_late`,

			(
				SELECT COUNT(*)
				FROM `tasks`
				WHERE `tasks`.`status` = 2
				AND `tasks`.`due_by` > `tasks`.`completed_time`
				$where
			) AS `completed_on_time`,

			(
				SELECT ROUND(
							ABS(
								AVG(
									TIME_TO_SEC(
												TIMEDIFF(
														`tasks`.`created_time`, `tasks`.`completed_time`
														)
												)
									)
								)
							)
				FROM `tasks`
				WHERE `tasks`.`status` = 2
				$where
			) AS `average_completion_time`,

			(
				SELECT COUNT(*)
				FROM `users`
			) AS `user_count`

		");

		if (!is_null($uid)){
			$query->bindValue(':uid', $uid);
		}

		$query->execute();

		$stats = $query->row();

		if ($stats['completed'] > 0){
			$stats['completed_on_time_percentage'] = round(($stats['completed_late'] / $stats['completed'] * 100), 2);
		} else {
			$stats['completed_on_time_percentage'] = 100;
		}
		
		$stats['avg_tasks_per_user'] = floor($stats['total'] / $stats['user_count']);
		$stats['average_completion_time'] = \WebInterface\DateFormat::timeFormat($stats['average_completion_time'], true);


		return $stats;
	}

	static public function getTaskDistribution(){

		$query = new \DBQuery("SELECT 
			`tasks`.`assignee_uid`,
			COUNT(*) AS `count`,
			`users`.`name`
			FROM `tasks` 
			JOIN `users` ON `users`.`id` = `tasks`.`assignee_uid`
			GROUP BY `tasks`.`assignee_uid`
		");

		$query->execute();

		return $query->results();

	}


}