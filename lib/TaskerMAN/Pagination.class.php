<?php
namespace TaskerMAN;

/*
* General concept for this class and some code comes from:
* http://gazellewhatcd.googlecode.com/svn-history/r2/trunk/classes/script_start.php
*/

class Pagination {
	
	private $NumPages;
	private $CurrentPage;
	private $URL;
	private $ItemsPerPage = 25;

	private $NumPagesToShow = 9;

	private $output;

	public function setNumPages($NumPages){
		$this->NumPages = $NumPages;
	}

	public function setCurrentPage($CurrentPage){
		$this->CurrentPage = $CurrentPage;
	}

	public function setURL($URL){
		$this->URL = $URL;
	}

	public function setItemsPerPage($ItemsPerPage){
		$this->ItemsPerPage = $ItemsPerPage;
	}

	public function setNumItems($NumItems){
		$this->NumItems = $NumItems;
	}

	public function get(){
		return $this->output;
	}

	public function generate(){

		$this->output = '<ul class="pagination">';

    	$this->CurrentPage = ceil($this->CurrentPage);
		if ($this->CurrentPage == 0){
			$this->CurrentPage = 1;
		}
	
		if ($this->NumItems > 0) {
		    if ($this->CurrentPage > ceil($this->NumItems / $this->ItemsPerPage)){
		    	$this->CurrentPage = ceil($this->NumItems / $this->ItemsPerPage);
		    }
	
		    $this->NumPagesToShow--; 
			$TotalPages = ceil($this->NumItems / $this->ItemsPerPage);
	
			if ($TotalPages>$this->NumPagesToShow) {
				$StartPosition = $this->CurrentPage - round($this->NumPagesToShow / 2);
	
				if ($StartPosition <= 0){
					$StartPosition = 1;
				} else {
					if ($StartPosition >= ($TotalPages - $this->NumPagesToShow)){
						$StartPosition = $TotalPages - $this->NumPagesToShow;
					}
				}
	
				$StopPage = $this->NumPagesToShow + $StartPosition;
	
			} else {
				$StopPage = $TotalPages;
				$StartPosition = 1;
			}
	
			if ($StartPosition < 1){
				$StartPosition = 1;
			}
	
			if ($this->CurrentPage > 1){
				$this->output .= '<li class="prev first"><a href="' . $this->URL . '/1"><strong>&lt;&lt; First</strong></a></li>';
				$this->output .= '<li class="prev"><a href="'.$this->URL . '/' . ($this->CurrentPage - 1) . '"><strong>&lt; Prev</strong></a></li>';
			}
	
			for ($i=$StartPosition; $i <= $StopPage; $i++) {
				if ($i != $this->CurrentPage) {
					$this->output .= '<li><a href="' . $this->URL . '/' . $i . '">';
				} else {
					$this->output .= '<li class="current">';
				}

				if ($i * $this->ItemsPerPage > $this->NumItems){
					$this->output .= ((($i - 1) * $this->ItemsPerPage) + 1) . '-' . ($this->NumItems);
				} else {
					$this->output .= ((($i - 1) * $this->ItemsPerPage) + 1) . '-' . ($i * $this->ItemsPerPage);
				}
				
				if ($i != $this->CurrentPage){
					$this->output .= '</a></li>';
				} else {
					$this->output .= '</li>';
				}

			}
	
			if ($this->CurrentPage < $TotalPages){
				$this->output .= '<li class="next"><a href="' . $this->URL . '/' . ($this->CurrentPage + 1) . '"><strong>Next &gt;</strong></a></li>';
				$this->output .= '<li class="next last"><a href="' . $this->URL . '/last"><strong> Last &gt;&gt;</strong></a></li>';
			}
		}
	
		$this->output .= '</ul>';

		if ($TotalPages > 1){
			return $this->output;
		}

	}

}