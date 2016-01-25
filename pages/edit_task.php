<?php

$task_id = IO::GET('id');

$task = new TaskerMAN\Task($task_id);

if (is_null($task->id)){
	throw new \FatalException('404 - Page Not Found', new \Exception('Requested task ('  . $task_id . ') was not found'));
}

$task->setTitle(IO::POST('task-title'));
$task->setDueBy(IO::POST('due-date'));
$task->setAssignee(IO::POST('assigned-to'));

$task->save();

header('Location: index.php?p=task&id=' . $task_id);