<?php

$tasks = range(1, 100);

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
$query = new PDOQuery("SELECT `id` FROM `users`");
$query->execute();

while ($row = $query->row()){
	$users[] = $row['id'];
}

// Get array of all admins
$query = new PDOQuery("SELECT `id` FROM `users` WHERE `admin` = '1'");
$query->execute();

while ($row = $query->row()){
	$admins[] = $row['id'];
}

foreach ($tasks as $i){

	$t = new Task();
	$t->setAssignee($users[array_rand($users)]);
	$t->setDueBy(date('Y-m-d H:i:s', rand_future_time()));
	$t->setCreatedByUser($admins[array_rand($admins)]);
	$status = rand(1, 2);
	$t->setStatus($status);

	$steps = range(1, rand(1, 3));
	foreach ($steps as $step_i){
		$t->createStep('Step #' . $step_i, 'Not done yet, sorry');
	}

	if ($status == 2){
		$t->setCompletedTime(date('Y-m-d H:i:s', rand_future_time()));
	}

	$t->setTitle($verbs[array_rand($verbs)] . ' the ' . $things[array_rand($things)]);
	$t->save();

}

function rand_future_time(){
	return time() + rand(3600, 86400) + (rand(0, 60) * 86400);
}