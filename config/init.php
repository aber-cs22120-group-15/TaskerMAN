<?php

date_default_timezone_set('Europe/London'); 


// Initialize autoloader
function CustomAutoLoader($class){

	if (substr($class, 0, 10) == 'TaskerMAN\\'){
		$lib_path = 'lib/TaskerMAN/';
		$exception_path = 'exceptions/TaskerMAN/';
		$class =  substr($class, 10);
	} elseif (substr($class, 0, 13) == 'WebInterface\\'){
		$lib_path = 'lib/WebInterface/';
		$exception_path = 'exceptions/WebInterface/';
		$class =  substr($class, 13);
	} else {
		$lib_path = 'lib/';
		$exception_path = 'exceptions/';
	}


	if (substr($class, strlen($class) - 9) == 'Exception'){

		require_once($exception_path . $class . '.class.php');
	} else { // Normal library include
		
		require_once($lib_path . $class . '.class.php');
	}
}

spl_autoload_register('CustomAutoLoader');

require_once('config/config.php');
