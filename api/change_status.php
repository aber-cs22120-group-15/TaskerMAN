<?php

$task_id = (int) IO::GET('id');
$status = (int) IO::GET('status');

$task = new TaskerMAN\Task($task_id);

if (empty($task->id)){
	// Unable to load task, throw error
	throw new TaskerMAN\APIErrorException('Invalid task ID');
}

switch ($status){

	// Make sure we're not setting the status to a state it's already in
	case $task->status:
		throw new TaskerMAN\APIErrorException('Trying to change status to same value as it already has');
	break;

	// allocated
	case 1:
		$task->setStatus(1);
		$task->setCompletedTime('0000-00-00 00:00:00');
	break;

	// completed
	case 2:
		$task->setStatus(2);
		$task->setCompletedTime();
	break;

	// Invalid status code
	default:
		echo TaskerMAN\API::error('Invalid status value (must be 1 or 2)');
		exit;
	break;
}

$task->save();

echo TaskerMAN\API::response('Success');