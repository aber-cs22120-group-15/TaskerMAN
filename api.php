<?php
header('Content-type: application/json');
require_once('config/init.php');

try {
	TaskerMAN\API::init();
} catch (TaskerMAN\APIErrorException $e){
	die(TaskerMAN\API::error($e->getMessage()));
} catch (FatalException $e){
	die(TaskerMAN\API::error($e->get_json()));
}