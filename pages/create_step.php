<?php

$task_id = IO::GET('task_id');

$step = new TaskerMAN\TaskStep();
$step->setTaskID(IO::GET('task_id'));
$step->setComment(IO::POST('comment'));
$step->setTitle(IO::POST('title'));
$step->save();

header('Location: index.php?p=task&id=' . $task_id);