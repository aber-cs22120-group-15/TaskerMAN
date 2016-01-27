<?php

// Get task ID to add this step to
$task_id = TaskerMAN\Core\IO::GET('task_id');

try {
	// Creates a new step, loads information, and then saves
	$step = new TaskerMAN\Application\TaskStep();
	$step->setTaskID(TaskerMAN\Core\IO::GET('task_id'));
	$step->setComment(TaskerMAN\Core\IO::POST('comment'));
	$step->setTitle(TaskerMAN\Core\IO::POST('title'));
	$step->save();
} catch (TaskerMAN\Application\TaskException $e){
	
}

// Redirect back to the task page
header('Location: index.php?p=task&id=' . $task_id);