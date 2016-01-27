<?php
namespace TaskerMAN\Core;

class DBQueryException extends FatalException {
	
	private $query = null;

	public function __construct($query, $e){

		$this->query = $query;

		parent::__construct('SQL Query Error', $e);
		parent::setExtraHTML($this->getHTML());
	}

	private function getHTML(){
		return '<div style="text-align: left"><strong>MySQL Query: </strong> <pre style="text-align: left">' . $this->query . '</pre></div>';
	}

		
}