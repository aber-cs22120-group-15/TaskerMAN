<?php

TaskerMAN\TaskListInterface::setSearchCriteria('assignee_uid', TaskerMAN\API::$uid);


echo TaskerMAN\API::response(array('tasks' => TaskerMAN\TaskListInterface::getTasks()));
exit;