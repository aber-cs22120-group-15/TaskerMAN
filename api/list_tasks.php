<?php

$TaskListInterface = new TaskerMAN\TaskListInterface();
$TaskListInterface->filterByUser(TaskerMAN\API::$uid);

if (isset($_GET['page'])){
	$TaskListInterface->setPage(IO::GET('page'));
}


echo TaskerMAN\API::response(array('tasks' => $TaskListInterface->execute()));
exit;