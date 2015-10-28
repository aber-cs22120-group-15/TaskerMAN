<?php

class FatalException {
	
	public function __construct($message, $e){
		ob_end_clean();

		echo '<h2>Fatal Error</h2>';
		echo $message;

		if (Registry::getConfig('DEBUG')){
			echo '<br /><br />';
			echo '<strong>Error: </strong><br />';
			echo '<pre>' . $e->getMessage() . '</pre>';

			echo '<br /><br />';
			echo '<strong>Stack Trace: </strong><br />';
			echo '<pre>' . $e->getTraceAsString() . '</pre>';
		}

		exit;
	}

}