<?php
WebInterface\WebInterface::setTitle('Dashboard');

$stats = TaskerMAN\DashboardStats::getStats();
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<div class="row placeholders">
		<div class="col-xs-6 col-sm-3 placeholder">
			<br />
			<br />
			<span class="large-dashboard-number"><?=$stats['outstanding']?></span>
		</div>

		<div class="col-xs-6 col-sm-3 placeholder">
			<br />
			<br />
			<?php
			echo '<span class="large-dashboard-number"';
			if ($stats['overdue'] > 0){
				echo ' style="color: #F7464A"';
			} else {
				echo ' style="color: #66CD00"';
			}
			echo '>' . $stats['overdue'] . '</span>';
			?>
		</div>

		<div class="col-xs-6 col-sm-3 placeholder">
			<canvas id="chart-task-distribution" width="200" height="200"></canvas>

			<?php
			// Generate JavaScript 
			$js_task_distribution = array();

			foreach (TaskerMAN\DashboardStats::getTaskDistribution() as $item){

				$color = WebInterface\PieChart::generatePastelColours($item['assignee_uid']);

				$js_task_distribution[] = '
					{
						value: ' . $item['count'] . ',
						color: "' . $color['color'] . '",
						highlight: "' . $color['highlight'] . '",
						label: "' . $item['name'] . '"
					}';
			}
			?>

			<script type="text/javascript">
				var ctx_task_distribution = document.getElementById("chart-task-distribution").getContext("2d");
				var data = [
					<?=implode(",\n", $js_task_distribution)?>
				]
				new Chart(ctx_task_distribution).Pie(data);
			</script>
		</div>

		<div class="col-xs-6 col-sm-3 placeholder">
			<canvas id="chart-on-time" width="200" height="200"></canvas>
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
				new Chart(ctx_on_time).Pie(data);
			</script>
		</div>
	</div>


	<div class="row placeholders">

		<div class="col-xs-6 col-sm-3 placeholder">
			<h4>Outstanding Tasks</h4>
			<span class="text-muted"><?=$stats['due_in_week']?> due in the next week</span>
		</div>

		<div class="col-xs-6 col-sm-3 placeholder">
			<h4>Overdue Tasks</h4>
			<span class="text-muted"><?=$stats['due_in_24h']?> due in the next 24 hours</span>
		</div>

		<div class="col-xs-6 col-sm-3 placeholder">
			<h4>Task Distribution</h4>
			<span class="text-muted"><?=$stats['avg_tasks_per_user']?> average tasks per user</span>
		</div>

		<div class="col-xs-6 col-sm-3 placeholder">
			<h4>Completed On Time</h4>
			<span class="text-muted"><?=$stats['completed_on_time_percentage']?>&#37; of tasks completed on time</span>
		</div>
	
	</div>


<?php
$Pagination = new WebInterface\WebPagination();
$Pagination->setItemsPerPage(5);
$Pagination->setNumItems(TaskerMAN\TaskListInterface::getNumTasks());
$Pagination->setCurrentPage(IO::GET('page'));
$Pagination->setBaseURL('index.php?p=main');

TaskerMAN\TaskListInterface::setStartPosition($Pagination->generateLIMITStartPosition());
TaskerMAN\TaskListInterface::setLimit($Pagination->getItemsPerPage());
$TaskData = TaskerMAN\TaskListInterface::getTasks();
print_r($TaskData);
?>

	<h2 class="sub-header">Outstanding Tasks</h2>
	<div class="table-responsive">

    <table class="table-striped table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Title</th>
          <th>Due By</th>
          <th>Assigned To</th>
        </tr>
      </thead>

      <tbody>

      <?php
      foreach ($TaskData as $task){
echo '
<tr>
  <td>' . $task['id'] . '</td>
  <td>' . $task['title'] . '</td>
  <td>' . $task['id'] . '


</tr>
';
      }

      ?>

      </tbody>
    </table>

    <div align="center">
      <?=$Pagination->getOutput()?>
    </div>

	</div>
</div>
