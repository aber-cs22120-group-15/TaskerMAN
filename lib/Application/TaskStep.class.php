<?php
namespace TaskerMAN\Application;

class TaskStep {

	public $id;
	public $task_id;
	public $assignee_uid;
	public $title;
	public $comment;

	private $new_step = false;

	public function __construct($id = null){

		if (!empty($id)){
			$this->new_step = false;
			$this->load($id);
		} else {
			$this->new_step = true;
		}

	}

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

	public function setComment($comment){
		$this->comment = $comment;
	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function setTaskID($task_id){
		$this->task_id = $task_id;
	}

	public function delete(){

		$query = new \TaskerMAN\Core\DBQuery("DELETE FROM `steps`
			WHERE `id` = ?
			LIMIT 1
		");

		$query->execute($this->id);

		return true;
	}

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

			$query->bindValue(':id', $this->task_id);
			$query->bindValue(':title', $this->title);
			$query->bindValue(':comment', $this->comment);

			$query->execute();
		}

	}

}