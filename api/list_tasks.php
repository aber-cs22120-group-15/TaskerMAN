<?php

$user_tasks = new UserTaskRelation($API->uid);
$tasks = $user_tasks->get();

echo $API->response(array('tasks' => $tasks));
exit;