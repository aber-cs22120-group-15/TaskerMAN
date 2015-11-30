<?php

$ids = explode(',', IO::GET('id'));

foreach ($ids as $key => $id){
	if (!is_numeric($id)){
		unset($ids[$key]);
	}
}

$steps = array();

foreach ($ids as $id){

	$task = new TaskerMAN\Task($id);
	if (is_null($task->id)){
		// Unable to load task
		throw new TaskerMAN\APIErrorException('Task ' . $id . ' does not exist');
	}

	if ((int) $task->assignee_uid !== TaskerMAN\API::$uid){
		throw new TaskerMAN\APIErrorException('User does not have access to task ' . $id);
	}

	$steps[$id] = $task->getSteps();

}

echo TaskerMAN\API::response(array('steps' => $steps));
