<?php

$id = (int) TaskerMAN\Core\IO::GET('id');
$comment = TaskerMAN\Core\IO::POST('comment', false);

$step = new TaskerMAN\Application\TaskStep($id);

if ($step->task_id === NULL){
	// Unable to load step, does not exist
	throw new TaskerMAN\Application\APIErrorException('Unknown step ID');
}

// Check that user is permitted to modify this task
if ((int) $step->assignee_uid != TaskerMAN\Application\API::$uid){
	throw new TaskerMAN\Application\APIErrorException('User does not have access to modify this step');
}

// Set comment and commit changes
try {
	$step->setComment($comment);
	$step->save();
} catch (TaskerMAN\Application\TaskException $e){
	throw new TaskerMAN\Application\APIErrorException($e->getMessage());
}

echo TaskerMAN\Application\API::response('Step comment updated successfully');


