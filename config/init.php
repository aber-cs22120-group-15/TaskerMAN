<?php

date_default_timezone_set('Europe/London'); 


// Initialize autoloader
function CustomAutoLoader($class){

	/*echo 'Class: ' . $class . "\n\n";
	debug_print_backtrace();*/

	if (substr($class, 0, 22) == 'TaskerMAN\Application\\'){
		$lib_path = 'lib/Application/';
		$exception_path = 'exceptions/Application/';
		$class =  substr($class, 22);
	} elseif (substr($class, 0, 23) == 'TaskerMAN\WebInterface\\'){
		$lib_path = 'lib/WebInterface/';
		$exception_path = 'exceptions/WebInterface/';
		$class =  substr($class, 23);
	} elseif (substr($class, 0, 15) == 'TaskerMAN\Core\\') {
		$lib_path = 'lib/Core/';
		$exception_path = 'exceptions/Core/';
		$class =  substr($class, 15);
	} else {
		$lib_path = '';
		$exception_path = '';
	}


	if (substr($class, strlen($class) - 9) == 'Exception'){
			@include_once($exception_path . $class . '.class.php');
	} else { // Normal library include
			@include_once($lib_path . $class . '.class.php');
	}
}

spl_autoload_register('CustomAutoLoader');

require_once('config/config.php');
