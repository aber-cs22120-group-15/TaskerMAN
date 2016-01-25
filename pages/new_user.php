<?php

WebInterface\WebInterface::setTitle('Create New User');

if (isset($_POST['submit'])){
	// Form submitted
	
	if (isset($_POST['admin'])){
		$is_admin = true;
	} else {
		$is_admin = false;
	}
		
	// Update user
	try {

		$uid = TaskerMAN\UserManagement::create(IO::POST('email'), IO::POST('name'), IO::POST('password'), $is_admin);

		header('Location: index.php?p=user&id=' . $uid);

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

	<h2 class="page-header">Create New User</h2>

	<div class="row placeholders">
		<div class="col-md-6">
			<form method="post" action="index.php?p=new_user">

				<div class="input-group input-group-lg">
					<span class="input-group-addon" id="sizing-addon1">Name</span>
	  				<input type="text" name="name" class="form-control" placeholder="Name" aria-describedby="sizing-addon1" value="<?=IO::POST('name')?>">
  				</div>
  				
  				<br />

  				<div class="input-group input-group-lg">
	  				<span class="input-group-addon" id="sizing-addon2">Email Address</span>
	  				<input type="email" name="email" class="form-control" placeholder="Email Address" aria-describedby="sizing-addon2" value="<?=IO::POST('email')?>">
  				</div>

  				<br />

  				<div class="input-group input-group-lg">
	  				<span class="input-group-addon" id="sizing-addon3">Password</span>
	  				<input type="password" name="password" class="form-control" placeholder="Password" aria-describedby="sizing-addon3">
  				</div>

  				<br />

  				<div class="input-group input-group">
	  				<span class="input-group-addon" id="sizing-addon4">Administrator </span>
	  				<input type="checkbox" name="admin" class="form-control" placeholder="Password" aria-describedby="sizing-addon4" <?php if (isset($_POST['admin'])) echo 'checked'; ?>>	  				
  				</div>

  				<br />

  				<div class="input-group input-group-lg">
	  				<input type="submit" name="submit" value="Submit" class="btn btn-lg btn-primary" />
	  			</div>

  			</form>
		</div>
	</div>

</div>