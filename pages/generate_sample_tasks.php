<?php

$tasks = range(1, 100);

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

	if ($status == 2){
		$t->setCompletedTime(date('Y-m-d H:i:s', rand_future_time()));
	}

	$t->setTitle('Title #' . $i);
	$t->save();

}

function rand_future_time(){
	return time() + rand(0, 86400) + (rand(0, 60) * 86400);
}