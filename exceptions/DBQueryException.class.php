<?php

class DBQueryException {
	
	public function __construct($query, $e){
		ob_end_clean();

		echo '<h2>Fatal error</h2>';
		echo 'A fatal, unexpected error has occurred.';

		if (Registry::getConfig('DEBUG')){
			echo '<br /><br /><strong>MySQL Error: </strong> <pre>' . $e->getMessage() . '</pre>';
			echo '<br /><br /><strong>MySQL Query: </strong> <pre>' . $query . '</pre>';
			echo '<br /><br /><strong>Stack trace: </strong><br />
			<pre>' . $e->getTraceAsString() . '</pre>';
		}
		exit;
	}
}