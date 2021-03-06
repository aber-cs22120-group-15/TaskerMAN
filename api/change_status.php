<?php

// Get task ID and status variables
$task_id = (int) TaskerMAN\Core\IO::GET('id');
$status = (int) TaskerMAN\Core\IO::GET('status');

// Expects time in UNIX timestamp format
$completed_time = (int) TaskerMAN\Core\IO::GET('completed_time');

// If no completed time is passed, use current time
if (empty($completed_time)){
	$completed_time = time();
}

$task = new TaskerMAN\Application\Task($task_id);

if (empty($task->id)){
	// Unable to load task, throw error
	throw new TaskerMAN\Application\APIErrorException('Invalid task ID');
}

switch ($status){

	// Make sure we're not setting the status to a state it's already in
	case $task->status:
		throw new TaskerMAN\Application\APIErrorException('Trying to change status to same value as it already has');
	break;

	// allocated
	case 1:
		$task->setStatus(1);
		$task->setCompletedTime('0000-00-00 00:00:00');
	break;

	// completed
	case 2:
		$task->setStatus(2);
		$task->setCompletedTime(date("Y-m-d H:i:s", $completed_time));
	break;

	// Invalid status code
	default:
		echo TaskerMAN\Application\API::error('Invalid status value (must be 1 or 2)');
		exit;
	break;
}

// Commit changes
$task->save();

// Return success response
echo TaskerMAN\Application\API::response('Success');