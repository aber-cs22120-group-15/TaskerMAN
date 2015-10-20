<?php

class TaskStep {
	

	public $id;
	public $task_id;
	public $assignee_uid;
	public $title;
	public $comment;

	public function __construct($id){
		$this->id = $id;
		$this->load();
	}

	private function load(){

		$query = new PDOQuery("SELECT `steps`.*,
			(
				SELECT `assignee_uid`
				FROM `tasks`
				WHERE `id` = `steps`.`task_id`
			) AS `assignee_uid`
			FROM `steps`
			WHERE `steps`.`id` = ?
			LIMIT 1
		");

		$query->execute($this->id);

		if ($query->rowCount() == 0){
			return false;
		}

		$fetch = $query->row();

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

	public function delete(){

		$query = new PDOQuery("DELETE FROM `steps`
			WHERE `id` = ?
			LIMIT 1
		");

		$query->execute($this->id);

		return true;
	}

	public function save(){

		$query = new PDOQuery("UPDATE `steps` SET
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