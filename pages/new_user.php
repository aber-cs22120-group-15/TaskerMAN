<?php

TaskerMAN\WebInterface\WebInterface::setTitle('Create New User');

if (isset($_POST['submit'])){
	// Form submitted
	
	// Is the user an administrator?
	if (isset($_POST['admin'])){
		$is_admin = true;
	} else {
		$is_admin = false;
	}
		
	// Update user
	try {

		$uid = TaskerMAN\Application\UserManagement::create(TaskerMAN\Core\IO::POST('email'), TaskerMAN\Core\IO::POST('name'), TaskerMAN\Core\IO::POST('password'), $is_admin);
		header('Location: index.php?p=user&id=' . $uid);
		exit;

	} catch (TaskerMAN\Application\UserManagementException $e){
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

	<h2 class="page-header">Create New User</h2>

	<div class="row placeholders">
		<div class="col-md-6">
			<form method="post" action="index.php?p=new_user">

				<div class="input-group input-group-md">
					<span class="input-group-addon" id="sizing-addon1">Name</span>
	  				<input type="text" name="name" class="form-control" placeholder="Name" aria-describedby="sizing-addon1" value="<?=TaskerMAN\Core\IO::POST('name')?>">
  				</div>
  				
  				<br />

  				<div class="input-group input-group-md">
	  				<span class="input-group-addon" id="sizing-addon2">Email Address</span>
	  				<input type="email" name="email" class="form-control" placeholder="Email Address" aria-describedby="sizing-addon2" value="<?=TaskerMAN\Core\IO::POST('email')?>">
  				</div>

  				<br />

  				<div class="input-group input-group-md">
	  				<span class="input-group-addon" id="sizing-addon3">Password</span>
	  				<input type="password" name="password" class="form-control" placeholder="Password" aria-describedby="sizing-addon3">
  				</div>

  				<br />

  				<div class="input-group input-group">
	  				<span class="input-group-addon" id="sizing-addon4">Administrator </span>
	  				<span class="input-group-addon">
	  					<input type="checkbox" name="admin" class="form-control" placeholder="Password" aria-describedby="sizing-addon4" <?php if (isset($_POST['admin'])) echo 'checked'; ?>>	  				
	  				</span>
  				</div>

  				<br />

  				<div class="input-group input-group-md">
	  				<input type="submit" name="submit" value="Submit" class="btn btn-md btn-primary" />
	  			</div>

  			</form>
		</div>
	</div>

</div>