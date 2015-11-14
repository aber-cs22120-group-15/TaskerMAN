<?php

TaskerMAN\TaskListInterface::setSearchCriteria('assignee_uid', TaskerMAN\API::$uid);
TaskerMAN\TaskListInterface::setStartPosition(0);
TaskerMAN\TaskListInterface::setLimit(25);

echo TaskerMAN\API::response(array('tasks' => TaskerMAN\TaskListInterface::getTasks()));
exit;