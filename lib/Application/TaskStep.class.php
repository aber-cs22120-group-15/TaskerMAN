<?php
namespace TaskerMAN\Application;

/**
 * This class creates an object for a task step
 *
 * @author Daniel K Monaghan <dkm2@aber.ac.uk>
 * @version 1.0
*/ 
class TaskStep {

	public $id;
	public $task_id;
	public $assignee_uid;
	public $title;
	public $comment;

	private $new_step = false;

	/**
	 * Initializes the task step object, loading data if given a step id
	 * 
	 * @param int id
	 */
	public function __construct($id = null){

		if (!empty($id)){
			$this->new_step = false;
			$this->load($id);
		} else {
			$this->new_step = true;
		}

	}

	/**
	 * Loads step data from the database into the object
	 * 
	 * @param int $id
	 * @return boolean
	*/
	private function load($id){

		$query = new \TaskerMAN\Core\DBQuery("SELECT `steps`.*,
			(
				SELECT `assignee_uid`
				FROM `tasks`
				WHERE `id` = `steps`.`task_id`
			) AS `assignee_uid`
			FROM `steps`
			WHERE `steps`.`id` = ?
			LIMIT 1
		");

		$query->execute($id);

		if ($query->rowCount() == 0){
			return false;
		}

		$fetch = $query->row();

		$this->id = $id;
		$this->task_id = $fetch['task_id'];
		$this->assignee_uid = $fetch['assignee_uid'];
		$this->title = $fetch['title'];
		$this->comment = $fetch['comment'];

		return true;
	}

	/**
	 * Sets the comment for the step
	 *
	 * @param string $comment
	*/
	public function setComment($comment){
		$this->comment = $comment;
	}

	/**
	 * Sets the title for the task
	 *
	 * @param string $title
	 * @throws TaskException
	 */
	public function setTitle($title){

		if (empty($title)){
			throw new TaskException('Task Step title cannot be blank');
			return false;
		}

		$this->title = $title;
	}

 	/**
 	 * Sets the task ID that this step belongs to
 	 *
 	 * @param int $task_id
 	*/
	public function setTaskID($task_id){
		$this->task_id = $task_id;
	}

 	/**
 	 * Deletes the step
 	 */
	public function delete(){

		$query = new \TaskerMAN\Core\DBQuery("DELETE FROM `steps`
			WHERE `id` = ?
			LIMIT 1
		");

		$query->execute($this->id);

		return true;
	}

 	/**
 	 * Saves any changes to the database
 	 */
	public function save(){

		if ($this->new_step){

			$query = new \TaskerMAN\Core\DBQuery("INSERT INTO `steps`
				(`task_id`, `title`, `comment`)
				VALUES
				(:task_id, :title, :comment)
			");

			$query->bindValue(':task_id', $this->task_id);
			$query->bindValue(':title', $this->title);
			$query->bindValue(':comment', $this->comment);

			$query->execute();

			$this->id = $query->lastInsertID();
		} else {

			$query = new \TaskerMAN\Core\DBQuery("UPDATE `steps` SET
				`title` = :title,
				`comment` = :comment

				WHERE `id` = :id
				LIMIT 1
			");

			$query->bindValue(':id', $this->id);
			$query->bindValue(':title', $this->title);
			$query->bindValue(':comment', $this->comment);

			$query->execute();

		}

	}

}
