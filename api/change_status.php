<?php
error_reporting(E_ALL);

$task_id = (int) $core->io->get('id');
$status = (int) $core->io->get('status');

$task = new task($task_id);

if (empty($task->id)){
	// Unable to load task, throw error
	echo $api->error('Invalid task ID');
	exit;
}

if (is_null($status) || ($status !== 0 && $status !== 1)){
	// No status passed
	echo $api->error('Invalid status value (must be 1 or 0)');
	exit;
}

if ($status == $task->status){
	echo $api->error('Trying to change status to same value as it already has');
	exit;
}

if ($status == 1){
	$task->setStatus(1);
	$task->setCompletedTime();
} else {
	$task->setStatus(0);
	$task->setCompletedTime('0000-00-00 00:00:00');
}

$task->save();

var_dump($task);
