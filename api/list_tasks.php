<?php

// Return all tasks for a specific user 
TaskerMAN\Application\TaskListInterface::setSearchCriteria('assignee_uid', TaskerMAN\Application\API::$uid);
TaskerMAN\Application\TaskListInterface::setStartPosition(0);

echo TaskerMAN\Application\API::response(array('tasks' => TaskerMAN\Application\TaskListInterface::getTasks()));
