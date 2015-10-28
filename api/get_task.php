<?php

$id = (int) IO::GET('id');

$task = new TaskerMAN\Task($id);

if (is_null($task->id)){
	// Unable to load task
	throw new TaskerMAN\APIErrorException('Task does not exist');
}

if ((int) $task->assignee_uid !== TaskerMAN\API::$uid){
	throw new TaskerMAN\APIErrorException('User does not have access to this task');
}

$result = array(

	'id' => $task->id,
	'created_uid' => $task->created_uid,
	'created_name' => $task->created_name,
	'assignee_uid' => $task->assignee_uid,
	'assignee_name' => $task->assignee_name,
	'due_by' => $task->due_by,
	'completed_time' => $task->completed_time,
	'status' => $task->status,
	'title' => $task->title,
	'steps' => $task->steps

);

echo TaskerMAN\API::response($result);
