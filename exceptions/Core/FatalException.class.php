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

		// Load template
		$template = file_get_contents('template/fatal_error.php');

		if (\TaskerMAN\Core\Registry::getConfig('DEBUG')){
			$html  = '<div style="text-align: left">';
			$html .= '<strong>Error: </strong><br />';
			$html .= '<pre>' . $this->e_message . '</pre>';
			$html .= '</div>';

			$html .=  $this->html;

			$html .= '<div style="text-align: left">';
			$html .= '<strong>Stack Trace: </strong><br />';
			$html .= '<pre style="white-space: nowrap; text-align: left">' . nl2br($this->trace) . '</pre>';
			$html .= '</div>';
		} else {
			$html = null;
		}


		$search = array('{{TITLE}}', '{{MAIN_MESSAGE}}', '{{EXTRA_HTML}}');
		$replace = array('An error occured', parent::getMessage(), $html);

		echo str_replace($search, $replace, $template);

		exit;

	}

	public function get_json(){

		if (\TaskerMAN\Core\Registry::getConfig('DEBUG')){

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