<?php

$task_id = TaskerMAN\Core\IO::GET('task_id');

$step = new TaskerMAN\Application\TaskStep();
$step->setTaskID(TaskerMAN\Core\IO::GET('task_id'));
$step->setComment(TaskerMAN\Core\IO::POST('comment'));
$step->setTitle(TaskerMAN\Core\IO::POST('title'));
$step->save();

header('Location: index.php?p=task&id=' . $task_id);