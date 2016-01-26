<?php


TaskerMAN\WebInterface\WebInterface::showTemplate(false);

$install = new TaskerMAN\Core\Install;

if (!$install->required()){
	throw new \FatalException('Install Not Required', new \Exception('All database tables already exist, so an install is not required.'));
}

$alert = null;

if (isset($_POST['submit'])){

	// Create tables
	$install->createTables();

	// Create user
	try {

		$uid = TaskerMAN\UserManagement::create(TaskerMAN\Core\IO::POST('email'), TaskerMAN\Core\IO::POST('name'), TaskerMAN\Core\IO::POST('password'), true);

		header('Location: index.php?p=user&id=' . $uid);

	} catch (TaskerMAN\UserManagementException $e){
		$alert = '<div class="alert alert-danger" role="alert">' . $e->getMessage() . '</div>';
	}

}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Install &middot; TaskerMAN</title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

	<link rel="stylesheet" href="static/css/login.css" />


	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

    	<?=$alert?>

   		<form class="form-signin" method="post" action="index.php?p=install">
			<h2 class="form-signin-heading">TaskerMAN &middot; Install</h2>


			<div class="panel panel-default">
			  <div class="panel-body">
			  	<p>
			   		<div align="center">Welcome to <strong>TaskerMAN</strong>!</div>
			   		<br /><br />
			   		Seeing as this is your first time using TaskerMAN, you need to go through a few quick setup steps.
			   		<br /><br />
			   		Firstly, please copy <code>config/config.php.tmp</code> to <code>config/config.php</code> and insert your MySQL database credentials.
			   		<br /><br />
			   		Once you have done that, you can create your first administrative user below.
			   	</p>
			  </div>
			</div>

			<?php
	    	if (!is_null($alert)){
	    		echo $alert;
	    	}

	    	if (isset($_POST['name'])){
	    		$name_placeholder = 'value="' . TaskerMAN\Core\IO::POST('name') . '"';
 	    	} else {
 	    		$name_placeholder = null;
 	    	}

	    	if (isset($_POST['email'])){
	    		$email_placeholder = 'value="' . TaskerMAN\Core\IO::POST('email') . '"';
 	    	} else {
 	    		$email_placeholder = null;
 	    	}
 	    	
	    	?>

	    	<label for="name" class="sr-only">Name</label>
			<input type="text" id="name" name="name" class="form-control" placeholder="Full Name" <?=$name_placeholder?> required autofocus>

			<label for="email" class="sr-only">Email address</label>
			<input type="email" id="email" name="email" class="form-control" placeholder="Email address" <?=$email_placeholder?> required autofocus>
			
			<label for="password" class="sr-only">Password</label>
			<input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
			
			<button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Create</button>
		</form>

    </div> <!-- /container -->
  </body>
</html>
