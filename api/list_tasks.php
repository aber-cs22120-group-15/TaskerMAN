<?php

TaskerMAN\TaskListInterface::setSearchCriteria('assignee_uid', TaskerMAN\API::$uid);
TaskerMAN\TaskListInterface::setStartPosition(0);

echo TaskerMAN\API::response(array('tasks' => TaskerMAN\TaskListInterface::getTasks()));
