<?php

$id = (int) $core->IO->get('id');

$task = new Task($id);

if (is_null($task->id)){
	// Unable to load task
	echo $API->error('Task does not exist');
	exit;
}

if ((int) $task->assignee_uid !== $API->uid){
	echo $API->error('User does not have access to this task');
	exit;
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

echo $API->response($result);
