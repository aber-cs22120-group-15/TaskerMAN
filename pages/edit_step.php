<?php

// Get task and step ID
$id = TaskerMAN\Core\IO::GET('id');
$task_id = TaskerMAN\Core\IO::GET('task_id');

// Load step 
$step = new TaskerMAN\Application\TaskStep($id);

// If unable to load step, redirect back to task page
if (is_null($step->id)){
	header('Location: index.php?p=task&id=' . $task_id);
	exit;
}

if (isset($_POST['delete'])){
	$step->delete();
} else {

	try {
		$step->setComment(TaskerMAN\Core\IO::POST('comment'));
		$step->setTitle(TaskerMAN\Core\IO::POST('title'));
		$step->save();
	} catch (TaskerMAN\Application\TaskException $e){
	
	}

}

header('Location: index.php?p=task&id=' . $task_id);