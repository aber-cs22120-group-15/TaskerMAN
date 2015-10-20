<?php

$user_tasks = new user_tasks($api->uid);
$tasks = $user_tasks->get();

echo $api->response(array('tasks' => $tasks));
exit;