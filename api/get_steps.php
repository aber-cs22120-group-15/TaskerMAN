<?php

$ids = explode(',', TaskerMAN\Core\IO::GET('id'));

foreach ($ids as $key => $id){
	if (!is_numeric($id)){
		unset($ids[$key]);
	}
}

$steps = array();

foreach ($ids as $id){

	$task = new TaskerMAN\Application\Task($id);
	if (is_null($task->id)){
		// Unable to load task
		throw new TaskerMAN\Application\APIErrorException('Task ' . $id . ' does not exist');
	}

	if ((int) $task->assignee_uid !== TaskerMAN\Application\API::$uid){
		throw new TaskerMAN\Application\APIErrorException('User does not have access to task ' . $id);
	}

	$steps[$id] = $task->getSteps();

}

echo TaskerMAN\Application\API::response(array('steps' => $steps));
