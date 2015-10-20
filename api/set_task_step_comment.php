<?php

$id = (int) $core->IO->get('id');
$comment = $core->IO->post('comment');

$step = new TaskStep($id);

if ($step->task_id === NULL){
	// Unable to load step, does not exist
	echo $API->error('Unknown step ID');
	exit;
}

if ((int) $step->assignee_uid != $API->uid){
	echo $API->error('User does not have access to modify this step');
	exit;
}

$step->setComment($comment);
$step->save();

echo $API->response('Step comment updated successfully');


