<?php

$task_id = (int) $core->IO->get('id');
$status = (int) $core->IO->get('status');

$task = new task($task_id);

if (empty($task->id)){
	// Unable to load task, throw error
	echo $API->error('Invalid task ID');
	exit;
}

switch ($status){

	// Make sure we're not setting the status to a state it's already in
	case $task->status:
		echo $API->error('Trying to change status to same value as it already has');
		exit;
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
		echo $API->error('Invalid status value (must be 1 or 2)');
		exit;
	break;
}

$task->save();

echo $API->response('Success');