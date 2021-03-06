<?php
namespace TaskerMAN\Application;

/**
 * Generates and returns statistics about tasks and users
 *
 * @author Daniel K Monaghan <dkm2@aber.ac.uk>
 * @version 1.0
*/
class DashboardStats {
	
	/**
	 * Returns statistics on task data
	 *
	 * @param int optional user id
	 * @return array statistics
	*/
	static public function getStats($uid = null){

		if (!is_null($uid)){
			$where = ' AND `assignee_uid` = :uid';
		} else {
			$where = null;
		}

		$query = new \TaskerMAN\Core\DBQuery("SELECT

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

		// Calculate percentage of tasks completed on time
		if ($stats['completed'] > 0){
			$stats['average_completion_time'] = \TaskerMAN\WebInterface\DateFormat::timeFormat($stats['average_completion_time'], true);
			$stats['completed_on_time_percentage'] = round(($stats['completed_on_time'] / $stats['completed'] * 100), 2);
		} else {
			$stats['average_completion_time'] = 'n/a';
			$stats['completed_on_time_percentage'] = 100;
		}
		
		$stats['avg_tasks_per_user'] = floor($stats['total'] / $stats['user_count']);
		


		return $stats;
	}

	/**
	 * Returns number of tasks assigned to each user
	 *
	 * @return array statistics
	*/
	static public function getTaskDistribution(){

		$query = new \TaskerMAN\Core\DBQuery("SELECT 
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