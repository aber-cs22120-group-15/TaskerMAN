<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=WebInterface::$title?> - TaskerMAN</title>	

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">


	<link href="static/css/dashboard.css" rel="stylesheet">

	</head>

	<body>
	 	<nav class="navbar navbar-inverse navbar-fixed-top">
	      <div class="container-fluid">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="navbar-brand" href="index.php?p=main">TaskerMAN</a>
	        </div>
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
	            <li><a href="index.php?p=settings"><?=WebInterface::$user->getName()?></a></li>
	            <li><a href="index.php?p=logout">Logout</a></li>
	          </ul>
	        </div>
	      </div>
	    </nav>

	    <div class="container-fluid">
	      <div class="row">
	        <div class="col-sm-3 col-md-2 sidebar">
	          <ul class="nav nav-sidebar">
	            <li class="active"><a href="#">Overview </a></li>
	            <li><a href="#">Reports</a></li>
	            <li><a href="#">Analytics</a></li>
	            <li><a href="#">Export</a></li>
	          </ul>
	          <ul class="nav nav-sidebar">
	            <li><a href="">Nav item</a></li>
	            <li><a href="">Nav item again</a></li>
	            <li><a href="">One more nav</a></li>
	            <li><a href="">Another nav item</a></li>
	            <li><a href="">More navigation</a></li>
	          </ul>
	          <ul class="nav nav-sidebar">
	            <li><a href="">Nav item again</a></li>
	            <li><a href="">One more nav</a></li>
	            <li><a href="">Another nav item</a></li>
	          </ul>
	        </div>