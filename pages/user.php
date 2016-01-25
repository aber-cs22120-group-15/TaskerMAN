<?php

$uid = IO::GET('id');

$user = new TaskerMAN\User($uid);

if (!$user->exists){
	throw new \FatalException('404 - Page Not Found', new \Exception('Requested user ('  . $uid . ') was not found'));
}

WebInterface\WebInterface::setTitle($user->name);
$stats = TaskerMAN\DashboardStats::getStats($user->id);

if (isset($_POST['submit'])){
	// Form submitted
	
	if (isset($_POST['admin'])){
		$is_admin = true;
	} else {
		$is_admin = false;
	}
		
	// Update user
	try {

		TaskerMAN\UserManagement::update($user->id, IO::POST('name'), IO::POST('email'), $is_admin);

		// Update password
		if (!empty(IO::POST('password'))){
			TaskerMAN\UserManagement::changePassword($user->id, IO::POST('password'));
		}

		// Reload user
		$user = new TaskerMAN\User($uid);
		$alert = '<div class="alert alert-info" role="alert">User settings were succesfully updated</div>';

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

	<h2 class="page-header"><?=$user->name?></h2>
	
	<div class="row placeholders">
		<div class="col-xs-6 col-sm-3 placeholder">
			<br />
			<span class="medium-dashboard-number"><?=$stats['outstanding']?></span>
		</div>

		<div class="col-xs-6 col-sm-3 placeholder">
			<br />
			<?php
			echo '<span class="medium-dashboard-number"';
			if ($stats['overdue'] > 0){
				echo ' style="color: #F7464A"';
			} else {
				echo ' style="color: #66CD00"';
			}
			echo '>' . $stats['overdue'] . '</span>';
			?>
		</div>

		<div class="col-xs-6 col-sm-3 placeholder">
			<canvas id="chart-on-time" width="150" height="150"></canvas>
			<script type="text/javascript">
				var ctx_on_time = document.getElementById("chart-on-time").getContext("2d");
				var data = [
					{
						value: <?=$stats['completed_late']?>,
						color:"#F7464A",
						highlight: "#FF5A5E",
						label: "Completed Late"
					},
					{
						value: <?=$stats['completed_on_time']?>,
						color: "#66CD00",
						highlight: "#A6D785",
						label: "Completed On Time"
					}
				]
				new Chart(ctx_on_time).Pie(data, {
						tooltipFontSize: 10,
						tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",
						percentageInnerCutout : 50
					}	
				);
			</script>
		</div>

		<div class="col-xs-6 col-sm-3 placeholder">
			<ul class="list-group">
				<?php
				if ($user->isAdmin()){
					echo '<li class="list-group-item"><span class="label label-success">Administrator</span></li>';
				}
				?>
				<li class="list-group-item"><span class="label label-default">E-Mail Address</span> <?=$user->email?></li>
				<li class="list-group-item"><a class="btn btn-default btn-sm" href="index.php?p=list_tasks&amp;assignee_uid=<?=$user->id?>" role="button">View Tasks</a></li>
			</ul>
		</div>

	</div>


	<div class="row placeholders">

		<div class="col-xs-6 col-sm-3 placeholder">
			<h4>Outstanding Tasks</h4>
			<span class="text-muted"><?=$stats['due_in_week']?> due in the next week</span>
		</div>

		<div class="col-xs-6 col-sm-3 placeholder">
			<h4>Overdue Tasks</h4>
			<span class="text-muted"><?=$stats['completed_on_time_percentage']?>&#37; of tasks completed on time</span>
		</div>

		<div class="col-xs-6 col-sm-3 placeholder">
			<h4>Completed On Time</h4>
			<span class="text-muted"><?=$stats['average_completion_time']?> average completion time</span>
		</div>


		<div class="col-xs-6 col-sm-3 placeholder">

		</div>

	</div>

	<h2 class="sub-header">Settings</h2>
	<div class="row placeholders">
		<div class="col-md-6">
			<form method="post" action="index.php?p=user&amp;id=<?=$user->id?>">

				<div class="input-group input-group-md">
					<span class="input-group-addon" id="sizing-addon1">Name</span>
	  				<input type="text" name="name" class="form-control" placeholder="Name" aria-describedby="sizing-addon1" value="<?=$user->name?>">
  				</div>
  				
  				<br />

  				<div class="input-group input-group-md">
	  				<span class="input-group-addon" id="sizing-addon2">Email Address</span>
	  				<input type="email" name="email" class="form-control" placeholder="Email Address" aria-describedby="sizing-addon2" value="<?=$user->email?>">
  				</div>

  				<br />

  				<div class="input-group input-group-md">
	  				<span class="input-group-addon" id="sizing-addon3">Change Password</span>
	  				<input type="password" name="password" class="form-control" placeholder="Password" aria-describedby="sizing-addon3">
  				</div>

  				<br />

  				<div class="input-group input-group">
	  				<span class="input-group-addon" id="sizing-addon4">Administrator </span>
	  				<input type="checkbox" name="admin" class="form-control" placeholder="Password" aria-describedby="sizing-addon4" <?php if ($user->isAdmin()) echo 'checked'; ?>>	  				
  				</div>

  				<br />

  				<div class="input-group input-group-md">
	  				<input type="submit" name="submit" value="Submit" class="btn btn-md btn-primary" />
	  			</div>

  			</form>
		</div>
	</div>

</div>