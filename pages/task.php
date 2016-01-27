<?php

$task_id = TaskerMAN\Core\IO::GET('id');

// Check task exists
$task = new TaskerMAN\Application\Task($task_id);

if (is_null($task->id)){
	throw new \FatalException('404 - Page Not Found', new \Exception('Requested task ('  . $task_id . ') was not found'));
}

TaskerMAN\WebInterface\WebInterface::setTitle('Task ' . $task_id);
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

	<?php

	if (isset($_POST['submit'])){

		try {
			$task->setTitle(TaskerMAN\Core\IO::POST('task-title'));
			$task->setDueBy(TaskerMAN\Core\IO::POST('due-date'));
			$task->setAssignee(TaskerMAN\Core\IO::POST('assigned-to'));

			// Task changed to completed
			if ($task->status != 2 && TaskerMAN\Core\IO::POST('status') == 2){
				$task->setCompletedTime();
			}

			$task->setStatus(TaskerMAN\Core\IO::POST('status'));

			$task->save();

		} catch (TaskerMAN\Application\TaskException $e){
			$alert = '<div class="alert alert-danger" role="alert">' . $e->getMessage() . '</div>';

		}

	}

	if (isset($alert)){
		echo $alert;
	}

	switch($task->status){

		case 0:
			$label = '<span class="label label-default">Abandoned</span>';
		break;

		case 1:
			$label = '<span class="label label-primary">Allocated</span>';
		break;

		case 2:
			$label = '<span class="label label-success">Completed</span>';
		break;


		default:
			$label = null;
		break;


	}


	?>

	<h2 class="page-header">Manage Task #<?=$task->id?> &middot; <?=$label?></h2>

	<form method="post" action="index.php?p=task&amp;id=<?=$task->id?>">
		<div class="row placeholders">
			<div class="col-md-6">

				<div class="input-group input-group-md">
					<span class="input-group-addon" id="sizing-addon1">Task Title</span>
	  				<input type="text" name="task-title" class="form-control" placeholder="Title" aria-describedby="sizing-addon1" value="<?=$task->title?>" />
   				</div>
  				<br />

  				<div class="input-group input-group-md">
					<span class="input-group-addon" id="sizing-addon2">Due Date</span>
	  				<input type="date" name="due-date" class="form-control" aria-describedby="sizing-addon2" value="<?=$task->due_by?>">
  				</div>
  				<br />

  				<div class="input-group input-group-md">
					<span class="input-group-addon" id="sizing-addon3">Assigned To</span>
					<select name="assigned-to" class="form-control">
						<?=TaskerMAN\WebInterface\UserListDropdownGenerator::generate($task->assignee_uid)?>
					</select>
  				</div>
  				<br />

  				<div class="input-group input-group-md">
					<span class="input-group-addon" id="sizing-addon4">Status</span>
					<select name="status" class="form-control">
						<?=TaskerMAN\WebInterface\StatusDropdownGenerator::generate($task->status)?>
					</select>
  				</div>
  				<br />

  				<div class="input-group input-group-md">
	  				<input type="submit" name="submit" value="Submit" class="btn btn-md btn-primary" />
	  			</div>

			</div>
		</div>
	</form>

	<hr />

	<h3>Manage Steps</h3>

	<?php
	$steps = $task->getSteps();
	$i = 0;
	foreach ($steps as $step){
		$i++;
	?>

	<div class="panel panel-info">
	  	<div class="panel-heading">Step #<?=$i?></div>
	  	<div class="panel-body">
		  
			<form method="post" action="index.php?p=edit_step&amp;id=<?=$step['id']?>&amp;task_id=<?=$task->id?>">
				
				<div class="row placeholders">
					<div class="col-md-6">

						<div class="input-group input-group-md">
							<span class="input-group-addon" id="sizing-addon1">Step Title</span>
			  				<input type="text" name="title" class="form-control" placeholder="Step Title" aria-describedby="sizing-addon1" value="<?=$step['title']?>" />
		   				</div>
		  				<br />

		  				<div class="input-group input-group-md">
							<span class="input-group-addon" id="sizing-addon2">Step Comment</span>
			  				<input type="text" name="comment" class="form-control" aria-describedby="sizing-addon2" value="<?=$step['comment']?>">
		  				</div>
		  				<br />

		  				<div class="input-group input-group-md">
			  				<input type="submit" name="submit" value="Update" class="btn btn-md btn-primary" />

			  				<?php
			  				if (count($steps) > 1){
			  				?>
				  				&middot;
				  				<input type="submit" name="delete" value="Delete" class="btn btn-md btn-danger" />
			  				<?php
			  				}
			  				?>
			  			</div>


					</div>
				</div>

			</form>

		</div>
	</div>

	<?php

	}

	?>

	<hr />

	<div class="panel panel-default">
	  	<div class="panel-heading">Create New Step</div>
	  	<div class="panel-body">
		  
			<form method="post" action="index.php?p=create_step&amp;task_id=<?=$task->id?>">
				
				<div class="row placeholders">
					<div class="col-md-6">

						<div class="input-group input-group-md">
							<span class="input-group-addon" id="sizing-addon1">Step Title</span>
			  				<input type="text" name="title" class="form-control" placeholder="Step Title" aria-describedby="sizing-addon1" />
		   				</div>
		  				<br />

		  				<div class="input-group input-group-md">
							<span class="input-group-addon" id="sizing-addon2">Step Comment</span>
			  				<input type="text" name="comment" class="form-control" aria-describedby="sizing-addon2">
		  				</div>
		  				<br />

		  				<div class="input-group input-group-md">
			  				<input type="submit" name="submit" value="Submit" class="btn btn-md btn-primary" />
			  			</div>


					</div>
				</div>

			</form>

		</div>
	</div>


</div>
