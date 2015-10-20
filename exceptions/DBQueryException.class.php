<?php

class DBQueryException {
	
	public function __construct($query, $e){
		ob_end_clean();

		echo '<h2>Fatal error</h2>';
		echo 'A fatal, unexpected error has occurred.

		<br /><br /><strong>MySQL Error: </strong>' . $e->getMessage() . '
		<br /><br /><strong>Stack trace: </strong><br />
		<pre>' . $e->getTraceAsString() . '</pre>';
		exit;
	}
}