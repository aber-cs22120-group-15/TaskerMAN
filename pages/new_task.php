<?php

WebInterface\WebInterface::setTitle('Create New Task');

if (isset($_POST['submit'])){
	// Form submitted
		
	// Create Task
	try {

		// TODO - INPUT VALIDATION

	
		$task = new TaskerMAN\Task;
		$task->setCreatedByUser(WebInterface\WebInterface::$user->getID());
		$task->setAssignee(IO::POST('assigned-to'));
		$task->setDueBy(IO::POST('due-date'));
		$task->setStatus(0); // Allocated
		$task->setTitle(IO::POST('task-title'));

		$task->createStep(IO::POST('step-text'));

		$task->save();

		header('Location: index.php?p=task&id=' . $task->id);
		

	} catch (TaskerMAN\UserManagementException $e){
		$alert = '<div class="alert alert-danger" role="alert">' . $e->getMessage() . '</div>';
	}

}


?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

	<?php
	if (isset($alert)){
		echo $alert;
	}

	?>

	<h2 class="page-header">Create New Task</h2>

	<div class="row placeholders">
		<div class="col-md-6">
			<form method="post" action="index.php?p=new_task">

				<div class="input-group input-group-lg">
					<span class="input-group-addon" id="sizing-addon1">Task Title</span>
	  				<input type="text" name="task-title" class="form-control" placeholder="Title" aria-describedby="sizing-addon1" value="<?=IO::POST('task-title')?>">
  				</div>
  				<br />

  				<div class="input-group input-group-lg">
					<span class="input-group-addon" id="sizing-addon2">Due Date</span>
	  				<input type="date" name="due-date" class="form-control" aria-describedby="sizing-addon2" value="<?=IO::POST('due-date')?>">
  				</div>
  				<br />

  				<div class="input-group input-group-lg">
					<span class="input-group-addon" id="sizing-addon3">Assigned To</span>
					<select name="assigned-to" class="form-control">
						<?=WebInterface\UserListDropdownGenerator::generate(IO::POST('assigned-to'))?>
					</select>
  				</div>
  				<br />

  				<div class="input-group input-group-lg">
					<span class="input-group-addon" id="sizing-addon4">Initial Step</span>
	  				<input type="text" name="step-text" class="form-control" aria-describedby="sizing-addon4" value="<?=IO::POST('step-text')?>">
  				</div>
  				<br />

  				<div class="input-group input-group-lg">
	  				<input type="submit" name="submit" value="Submit" class="btn btn-lg btn-primary" />
	  			</div>

  			</form>
		</div>
	</div>

</div>