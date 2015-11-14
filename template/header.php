<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=WebInterface\WebInterface::$title?> - TaskerMAN</title>	

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
	<link href="static/css/dashboard.css" rel="stylesheet">
	<link href="static/css/taskerman.css" rel="stylesheet">
	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>

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
	            <li><a href="index.php?p=user&amp;id=<?=WebInterface\WebInterface::$user->getID()?>"><?=WebInterface\WebInterface::$user->getName()?></a></li>
	            <li><a href="index.php?p=logout">Logout</a></li>
	          </ul>
	        </div>
	      </div>
	    </nav>


<?php
// Build sidebar navigation
$sidebar = new WebInterface\SidebarNavigation();
$sidebar->setActiveHTML(' class="active"');
$sidebar->addItem('main', 'Dashboard');
$sidebar->addItem('new_task', 'New Task');
$sidebar->addItem('list_tasks', 'List All Tasks');
$sidebar->addItem('manage_users', 'Manage Users');
?>

	    <div class="container-fluid">
	      <div class="row">
	        <div class="col-sm-3 col-md-2 sidebar">
	          <ul class="nav nav-sidebar">

	          <?php
	          foreach ($sidebar->getItems() as $item){
	          	echo '<li' . $item['active_html'] . '><a href="index.php?p=' . $item['url'] . '">' . $item['text'] . '</a></li>' . "\n";
	          }
	          ?>
	          </ul>
	         
	        </div>