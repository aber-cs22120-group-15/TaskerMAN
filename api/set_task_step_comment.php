<?php

$id = (int) IO::GET('id');
$comment = urldecode(IO::POST('comment'));

$step = new TaskerMAN\TaskStep($id);

if ($step->task_id === NULL){
	// Unable to load step, does not exist
	throw new TaskerMAN\APIErrorException('Unknown step ID');
}

if ((int) $step->assignee_uid != TaskerMAN\API::$uid){
	throw new TaskerMAN\APIErrorException('User does not have access to modify this step');
}

$step->setComment($comment);
$step->save();

echo TaskerMAN\API::response('Step comment updated successfully');


