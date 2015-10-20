<?php


$task_id = (int) $core->io->get('id');
$status = $core->io->get('status');

$task = new task($task_id);

if (empty($task->id)){
	// Unable to load task, throw error
	echo $api->error('Invalid task ID');
	exit;
}

if (empty($status)){
	// No status passed
	echo $api->error('Invalid status value (must be 1 or 0)');
	exit;
}


/// THIS DOESN'T WORK
if ($status !== '0' && $status !== '1'){
	// No status passed
	echo $api->error('Invalid status value (must be 1 or 0)');
	exit;
}