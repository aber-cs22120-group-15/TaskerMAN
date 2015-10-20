<?php

$user_tasks = new UserTaskRelation($api->uid);
$tasks = $user_tasks->get();

echo $api->response(array('tasks' => $tasks));
exit;