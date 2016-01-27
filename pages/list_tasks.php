<?php

TaskerMAN\WebInterface\WebInterface::setTitle('List Tasks');

/*
 * Search constraint for creator
*/
$created_uid = TaskerMAN\Core\IO::GET('created_uid');
if ($created_uid == 'any'){
	$created_uid = null;
}
TaskerMAN\Application\TaskListInterface::setSearchCriteria('created_uid', $created_uid);

/*
 * Search constraint for assignee
*/
$assignee_uid = TaskerMAN\Core\IO::GET('assignee_uid');
if ($assignee_uid == 'any'){
	$assignee_uid = null;
}
TaskerMAN\Application\TaskListInterface::setSearchCriteria('assignee_uid', $assignee_uid);

/*
 * Search constraint for status
*/
$status = TaskerMAN\Core\IO::GET('status');
if ($status == 'any'){
	$status = null;
}
TaskerMAN\Application\TaskListInterface::setSearchCriteria('status', $status);

/**
 * Search constraint for title
*/
$title = TaskerMAN\Core\IO::get('title');
if (!empty($title)){
	TaskerMAN\Application\TaskListInterface::setSearchCriteria('title', '%' . strtolower($title) . '%');
}


// Pagination
$Pagination = new TaskerMAN\WebInterface\WebPagination();
$Pagination->setItemsPerPage(25);
$Pagination->setNumItems(TaskerMAN\Application\TaskListInterface::getNumTasks());
$Pagination->setCurrentPage(TaskerMAN\Core\IO::GET('page'));

// Generate base url
$base_url = 'index.php?';
foreach ($_GET as $key => $val){
	if ($key == 'page'){
		continue;
	}

	$base_url .= $key . '=' . TaskerMAN\Core\IO::sanitize($val) . '&amp;';
}

$base_url = trim($base_url, '&amp;');

$Pagination->setBaseURL($base_url);

TaskerMAN\Application\TaskListInterface::setStartPosition($Pagination->generateLIMITStartPosition());
TaskerMAN\Application\TaskListInterface::setLimit($Pagination->getItemsPerPage());


/**
 * Handle sorting
*/
$sort_col = TaskerMAN\Core\IO::get('sort_col');
$sort_dir = TaskerMAN\Core\IO::get('sort_dir');

if (empty($sort_col)){
  $sort_col = 'due_by';
} 

if (empty($sort_dir)){
  $sort_dir = 'ASC';
}

TaskerMAN\Application\TaskListInterface::setSort($sort_col, $sort_dir);


$TaskData = TaskerMAN\Application\TaskListInterface::getTasks(true);

?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <div class="row">
  <div class="col-md-8">

  <div class="panel panel-info">
    <div class="panel-heading"><h3 class="panel-title">Search Criteria</h3></div>
    <div class="panel-body">
        <form method="get" action="index.php">
          <input type="hidden" name="p" value="list_tasks" />

          <div class="row">

            <!-- Title -->
            <div class="col-lg-10">
              <div class="input-group">
                <span class="input-group-addon">
                  Title
                </span>
                <input type="text" name="title" class="form-control" placeholder="Task title" value="<?=$title?>" />
              </div>
            </div>

          </div>

          <br />

          <div class="row">

            <!-- Assignee -->
            <div class="col-lg-6">
              <div class="input-group">
                <span class="input-group-addon">
                  Assigned To
                </span>
                <select name="assignee_uid" class="form-control">
                  <option value="any">-----</option>
                  <?=TaskerMAN\WebInterface\UserListDropdownGenerator::generate($assignee_uid)?>
                </select>
              </div>
            </div>

            <!-- Creator -->
            <div class="col-lg-6">
              <div class="input-group">
                <span class="input-group-addon">
                  Creator
                </span>
                <select name="created_uid" class="form-control">
                  <option value="any">-----</option>
                  <?=TaskerMAN\WebInterface\UserListDropdownGenerator::generate($created_uid)?>
                </select>
              </div>
            </div>
          

          </div>

          <br />

          <div class="row">

           <!-- Status -->
            <div class="col-lg-4">
              <div class="input-group">
                <span class="input-group-addon">
                  Status
                </span>
                <select name="status" class="form-control">
                  <option value="any">-----</option>
                  <?=TaskerMAN\WebInterface\StatusDropdownGenerator::generate($status)?>
                </select>
              </div>
            </div>

            <!-- Sort Column -->
            <div class="col-lg-3">
              <div class="input-group">
                <span class="input-group-addon">
                  Sort By
                </span>
                <select name="sort_col" class="form-control">

                  <?php
                  $sort_columns = array('title' => 'Title', 'status' => 'Status', 'due_by' => 'Due By', 'completed_time' => 'Completed Time');

                  echo TaskerMAN\WebInterface\GenericDropdownGenerator::generate($sort_columns, $sort_col);

                  ?>
                </select>
              </div>
            </div>

            <!-- Sort Direction -->
            <div class="col-lg-3">
              <div class="input-group">
                <select name="sort_dir" class="form-control">
                  <?php
                  echo '<option value="ASC"';
                  if ($sort_dir == 'ASC'){
                    echo 'selected';
                  }
                  echo '>Ascending</option>';

                  echo '<option value="DESC"';
                  if ($sort_dir == 'DESC'){
                    echo 'selected';
                  }
                  echo '>Descending</option>';
                  ?>
                </select>
              </div>
            </div>

            <!-- Submit -->
            <div class="col-lg-2">
              <div class="btn-group">
                <input type="submit" class="btn btn-success" value="Go!" />
              </div>
            </div>

          </div>

        </form>
    </div>
  </div>
  </div>
</div>

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
        echo '<td><span title="' . $task->due_by . '">' . TaskerMAN\WebInterface\DateFormat::timeDifference($task->due_by) . '</span>';

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