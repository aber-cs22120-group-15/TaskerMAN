<?php

if ($core->Session->isLoggedIn()){
	header('Location: index.php?p=main');
	exit;
}

$core->Page->setTitle('Login');
$core->Page->showTemplate(false);

$error = null;

if (isset($_POST['submit'])){

	$login = new Login;
	$user = $login->verifyCredentials($core->IO->post('email'), $core->IO->post('password'));

	if (!$user){
		$error = '<span style="align: center; color: red">Invalid username or password combination</span>';
	} else {
		$core->Session->set('uid', $user);
		header('Location: index.php?p=main');
		exit;
	}
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Log in &middot; TaskerMAN</title>

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

   		<form class="form-signin" method="post" action="index.php?p=login">
			<h2 class="form-signin-heading">TaskerMAN</h2>

			<?php
	    	if (!is_null($error)){
	    		echo $error;
	    	}
	    	?>

			<label for="email" class="sr-only">Email address</label>
			<input type="email" id="email" name="email" class="form-control" placeholder="Email address" required autofocus>
			<label for="password" class="sr-only">Password</label>
			<input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
			<button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Sign in</button>
		</form>

    </div> <!-- /container -->
  </body>
</html>
