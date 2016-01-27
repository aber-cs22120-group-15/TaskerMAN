<?php
header('Content-type: application/json');
require_once('config/init.php');

try {
	TaskerMAN\Application\API::init();
} catch (TaskerMAN\Application\APIErrorException $e){
	die(TaskerMAN\Application\API::error($e->getMessage()));
} catch (TaskerMAN\Core\FatalException $e){
	die(TaskerMAN\Application\API::error($e->get_json()));
}