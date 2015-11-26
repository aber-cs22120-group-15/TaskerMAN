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


echo TaskerMAN\API::response(array('steps' => $task->getSteps()));
