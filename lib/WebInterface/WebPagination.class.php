<?php
namespace TaskerMAN\WebInterface;

/**
 * Handles the generation of pagination on the web interface
 *
 * @author Daniel K Monaghan <dkm2@aber.ac.uk>
 * @version 1.0
*/
class WebPagination {

	private $num_pages;
	private $num_items;
	private $current_page;
	private $base_url;

	private $items_per_page = 25;
	const NUM_PAGES_TO_SHOW = 8;

	private $output;

	/**
	 * Sets total number of items
	 *
	 * @param int $num_items Number of items
	*/
	public function setNumItems($num_items){

		$this->num_items = $num_items;

		$this->setNumPages(ceil($num_items / $this->items_per_page));
	}

	/**
	 * Sets total number of pages
	 *
	 * @param int $num_pages Number of pages
	*/
	private function setNumPages($num_pages){
		$this->num_pages = $num_pages;
	}

	/**
	 * Sets current page number
	 *
	 * @param int $current_page Current Page
	*/
	public function setCurrentPage($current_page){
		$this->current_page = ceil($current_page);

		// Check if current page is greater than last page
		if ($this->current_page > $this->num_pages){
			$this->current_page = $this->num_pages;
		}

		// Make sure current page isn't lower than 1
		if (!is_numeric($this->current_page) || $this->current_page < 1){
			$this->current_page = 1;
		}
	}

	/**
	 * Sets number of items per page
	 *
	 * @param int $count Items per page
	*/
	public function setItemsPerPage($count){
		$this->items_per_page = $count;
	}

	/**
	 * Sets base URL
	 *
	 * @param string $base_url Base URL
	*/
	public function setBaseURL($base_url){
		$this->base_url = $base_url;
	}

	/**
	 * Checks if pagination is needed
	 *
	 * @return boolean
	*/
	public function paginationNeeded(){
		if ($this->items_per_page >= $this->num_items){
			return false;
		}

		return true;
	}

	/**
	 * Returns HTML
	 *
	 * @return string HTML
	*/
	public function getOutput(){

		if (!is_null($this->output)){
			return $this->output;
		}

		// If no less items than required to make 2 pages, no pagination is needed
		if (!$this->paginationNeeded()){
			return null;
		}

		$this->output = '<nav><ul class="pagination">';
		$start_position = 0;

		if ($this->num_pages > self::NUM_PAGES_TO_SHOW){
			$start_position = $this->current_page - round(self::NUM_PAGES_TO_SHOW / 2);

			// If position is less than page 1, set to 1
			if ($start_position < 1){
				$start_position = 1;
			} else {
				if ($start_position >= ($this->num_pages - self::NUM_PAGES_TO_SHOW)){
					$start_position = $this->num_pages - self::NUM_PAGES_TO_SHOW;
				}
			}

			// Stop position
			$stop_position = $start_position + self::NUM_PAGES_TO_SHOW;

		} else {
			$stop_position = $this->num_pages;
		}

		// If position is less than page 1, set to 1
		if ($start_position < 1){
			$start_position = 1;
		}

		// Display 'First' and 'Previous'
		if ($this->current_page > 1){
			$this->output .= '<li><a href="' . $this->base_url . '&amp;page=' . ($this->current_page - 1)  . '">&laquo;</a></li>';
		}

		for ($i = $start_position; $i <= $stop_position; $i++){

			// If current page, no link, and display active state
			if ($i == $this->current_page){
				$this->output .= '<li class="active"><a href="#">';
			} else {
				$this->output .= '<li><a href="' . $this->base_url . '&amp;page=' . $i . '">';
			}

			// Display page number
			$this->output .= $i;

			// Close item
			$this->output .= '</a></li>';
		}

		if ($this->current_page < $this->num_pages){
			$this->output .= '<li><a href="' . $this->base_url . '&amp;page=' . ($this->current_page + 1)  . '">&raquo;</a></li>';
		}

		$this->output .= '</ul></nav>';

		return $this->output;

	}

	/**
	 * Return position of starting item on current page
	 * for SQL LIMIT statement
	 * 
	 * @return int Starting item
	*/
	public function generateLIMITStartPosition(){
		 return ($this->current_page - 1) * $this->items_per_page;
	}

	/**
	 * Returns items per page
	 *
	 * @return int Items per page
	*/
	public function getItemsPerPage(){
		return $this->items_per_page;
	}


}