<?php

// Get array of task IDs 
$ids = explode(',', TaskerMAN\Core\IO::GET('id'));

// Remove non-numeric IDs
foreach ($ids as $key => $id){
	if (!is_numeric($id)){
		unset($ids[$key]);
	}
}

$steps = array();

// Loop through each task
foreach ($ids as $id){

	$task = new TaskerMAN\Application\Task($id);
	if (is_null($task->id)){
		// Unable to load task
		throw new TaskerMAN\Application\APIErrorException('Task ' . $id . ' does not exist');
	}

	if ((int) $task->assignee_uid !== TaskerMAN\Application\API::$uid){
		throw new TaskerMAN\Application\APIErrorException('User does not have access to task ' . $id);
	}

	// Load steps into response array
	$steps[$id] = $task->getSteps();

}

if (empty($steps)){
	throw new TaskerMAN\Application\APIErrorException('No steps found');
}

echo TaskerMAN\Application\API::response(array('steps' => $steps));
