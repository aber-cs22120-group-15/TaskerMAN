<?php

$tasks = range(1, 50);

// Title generation
$verbs = array(
	'Fix',
	'Create',
	'Confirm',
	'Eat',
	'Drink',
	'Paint',
	'Code',
	'Test'
);

$things = array(
	'beer',
	'user interface',
	'burgers',
	'pizza',
	'code',
	'Jack Reed',
	'desktop application',
	'Java',
	'PHP',
	'coffee',
	'meeting',
	'pasta'
);

// Get array of all user IDs
$query = new TaskerMAN\Core\DBQuery("SELECT `id` FROM `users`");
$query->execute();

while ($row = $query->row()){
	$users[] = $row['id'];
}

// Get array of all admins
$query = new TaskerMAN\Core\DBQuery("SELECT `id` FROM `users` WHERE `admin` = '1'");
$query->execute();

while ($row = $query->row()){
	$admins[] = $row['id'];
}

foreach ($tasks as $i){

	$t = new TaskerMAN\Application\Task();
	$t->setAssignee($users[array_rand($users)]);
	$due_by = rand_future_time() - (86400 * 4);
	$t->setDueBy(date('Y-m-d H:i:s', $due_by));
	$t->setCreatedByUser($admins[array_rand($admins)]);

	if (rand(1, 5) > 2){
		$status = 2;
	} else {
		$status = 1;
	}

	$t->setStatus($status);

	$steps = range(1, rand(1, 3));
	foreach ($steps as $step_i){
		$t->createStep('Step #' . $step_i, 'Not done yet, sorry');
	}

	if ($status == 2){

		// Should this task be completed late or on time?
		if (rand(0, 10) < 8){
			// On time
			// Generate a time between created time and due date
			$complete_time = rand(time(), $due_by);
		} else {
			// Late
			// Generate a time between due date, and 2 weeks after due date
			$complete_time = rand($due_by, $due_by + (14 * 86400));
		}


		$t->setCompletedTime(date('Y-m-d H:i:s', $complete_time));
	}

	$t->setTitle($verbs[array_rand($verbs)] . ' the ' . $things[array_rand($things)]);
	$t->save();

}

function rand_future_time(){
	return time() + rand(3600, 86400) + (rand(0, 60) * 86400);
}