<?php

class DBQueryException extends FatalException {
	
	private $query = null;

	public function __construct($query, $e){

		$this->query = $query;

		parent::__construct('SQL Query Error', $e);
		parent::setExtraHTML($this->getHTML());
	}

	private function getHTML(){
		return '<strong>MySQL Query: </strong> <pre>' . $this->query . '</pre>';
	}

		
}