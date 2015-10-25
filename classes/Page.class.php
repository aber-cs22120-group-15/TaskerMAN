<?php

class Page {
	
	public $page;
	public $title;
	public $showTemplate = true;


	public function setPage($page){
		$this->page = $page;
	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function showTemplate($bool = true){
		$this->showTemplate = $bool;
	}

}