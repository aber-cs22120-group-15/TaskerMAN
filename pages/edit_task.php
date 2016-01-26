<?php

$task_id = TaskerMAN\Core\IO::GET('id');

$task = new TaskerMAN\Application\Task($task_id);

if (is_null($task->id)){
	throw new \FatalException('404 - Page Not Found', new \Exception('Requested task ('  . $task_id . ') was not found'));
}

$task->setTitle(TaskerMAN\Core\IO::POST('task-title'));
$task->setDueBy(TaskerMAN\Core\IO::POST('due-date'));
$task->setAssignee(TaskerMAN\Core\IO::POST('assigned-to'));

$task->save();

header('Location: index.php?p=task&id=' . $task_id);