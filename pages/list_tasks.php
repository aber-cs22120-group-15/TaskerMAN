<?php

WebInterface\WebInterface::setTitle('List Tasks');

/*
 * Search constraint for creator
*/
$created_uid = IO::GET('created_uid');
if ($created_uid == 'any'){
	$created_uid = null;
}
TaskerMAN\TaskListInterface::setSearchCriteria('created_uid', $created_uid);

/*
 * Search constraint for assignee
*/
$assignee_uid = IO::GET('assignee_uid');
if ($assignee_uid == 'any'){
	$assignee_uid = null;
}
TaskerMAN\TaskListInterface::setSearchCriteria('assignee_uid', $assignee_uid);

/*
 * Search constraint for status
*/
$status = IO::GET('status');
if ($status == 'any'){
	$status = null;
}
TaskerMAN\TaskListInterface::setSearchCriteria('status', $status);

/**
 * Search constraint for title
*/
$title = IO::get('title');
if (!empty($title)){
	TaskerMAN\TaskListInterface::setSearchCriteria('title', '%' . strtolower($title) . '%');
}


// Pagination
$Pagination = new WebInterface\WebPagination();
$Pagination->setItemsPerPage(25);
$Pagination->setNumItems(TaskerMAN\TaskListInterface::getNumTasks());
$Pagination->setCurrentPage(IO::GET('page'));

// Generate base url
$base_url = 'index.php?';
foreach ($_GET as $key => $val){
	if ($key == 'page'){
		continue;
	}

	$base_url .= $key . '=' . IO::sanitize($val) . '&amp;';
}

$base_url = trim($base_url, '&amp;');

$Pagination->setBaseURL($base_url);

TaskerMAN\TaskListInterface::setStartPosition($Pagination->generateLIMITStartPosition());
TaskerMAN\TaskListInterface::setLimit($Pagination->getItemsPerPage());

TaskerMAN\TaskListInterface::setSort('id', 'ASC');

$TaskData = TaskerMAN\TaskListInterface::getTasks(true);
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

	<h2 class="page-header">Task List</h2>
	<div class="table-responsive">

    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th style="text-align: center;">#</th>
          <th>Title</th>
          <th>Due In</th>
          <th>Completed</th>
          <th>Assigned To</th>
        </tr>
      </thead>

      <tbody>

      <?php
      foreach ($TaskData as $task){

      	if ($task->status == 0){
      		$row_styling = ' class="danger"';
        } elseif ($task->status == 2){
        	$row_styling = ' class="success"';
        } else {
			    $row_styling = null;
       }

        echo '<tr' . $row_styling . '>';
        echo '<td style="text-align: center;">' . $task->id . '</td>';
        echo '<td><a href="index.php?p=task&amp;id=' . $task->id . '">' . $task->title . '</a></td>';
        echo '<td><span title="' . $task->due_by . '">' . WebInterface\DateFormat::timeDifference($task->due_by) . '</span>';

        if ($task->status == 1 && $task->isOverdue()){
          echo '&nbsp; <span class="label label-danger">Overdue!</span>';
        } elseif ($task->status == 1 && $task->dueSoon()){
          echo '&nbsp; <span class="label label-warning">Due soon!</span>';
        }

        echo '</td>';
        echo '<td>';

        if ($task->status == 2){
        	echo $task->completed_time;

        	if ($task->completedLate()){
        		echo '&nbsp; <span class="label label-warning">Late</span>';
        	}

        } else {
        	echo '--';
        }

        echo '</td>';

        echo '<td><a href="index.php?p=user&amp;id=' . $task->assignee_uid . '">' . $task->assignee_name . '</a></td>';
        echo '</tr>';

      }

      ?>

      </tbody>
    </table>

    <div align="center">
      <?=$Pagination->getOutput()?>
    </div>

	</div>


</div>