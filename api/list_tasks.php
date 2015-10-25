<?php

$TaskListInterface = new TaskListInterface();
$TaskListInterface->filterByUser($API->uid);

if (isset($_GET['page'])){
	$TaskListInterface->setPage($core->IO->get('page'));
}


echo $API->response(array('tasks' => $TaskListInterface->execute()));
exit;