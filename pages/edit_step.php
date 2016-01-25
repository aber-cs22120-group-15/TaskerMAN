<?php

$id = IO::GET('id');
$task_id = IO::GET('task_id');

$step = new TaskerMAN\TaskStep($id);

if (is_null($step->id)){
	header('Location: index.php?p=task&id=' . $task_id);
	exit;
}

if (isset($_POST['delete'])){

	$step->delete();

} else {

	$step->setComment(IO::POST('comment'));
	$step->setTitle(IO::POST('title'));
	$step->save();

}

header('Location: index.php?p=task&id=' . $task_id);