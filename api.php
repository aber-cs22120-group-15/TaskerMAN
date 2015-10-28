<?php

require_once('config/init.php');

try {
	TaskerMAN\API::init();
} catch (TaskerMAN\APIErrorException $e){
	die(TaskerMAN\API::error($e->getMessage()));
}