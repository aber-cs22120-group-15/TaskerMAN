<?php

class FatalException extends Exception {
	
	private $e_message = null;
	private $trace = null;
	private $html = null;

	public function __construct($message, $exception){
		parent::__construct($message);
		$this->e_message = $exception->getMessage();
		$this->trace = $exception->getTraceAsString();
	}

	public function setExtraHTML($html){
		$this->html = '<br /><br />' . $html;
	}

	public function display_html(){

		ob_end_clean();

		echo '<h2>Fatal Error</h2>';
		echo parent::getMessage();

		if (Registry::getConfig('DEBUG')){
			echo '<br /><br />';
			echo '<strong>Error: </strong><br />';
			echo '<pre>' . $this->e_message . '</pre>';

			echo $this->html;

			echo '<br /><br />';
			echo '<strong>Stack Trace: </strong><br />';
			echo '<pre>' . $this->trace . '</pre>';
		}

		exit;

	}

	public function get_json(){

		if (Registry::getConfig('DEBUG')){

			return array(
					'message' => $this->message,
					'exception_message' => $this->e_message,
					'trace' => $this->trace
				);

		} else {
			return array('message' => $this->message);
		}
	}

}