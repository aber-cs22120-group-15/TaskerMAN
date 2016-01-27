<?php
namespace TaskerMAN\WebInterface;

/**
 * Provides functions for generating sidebar navigation
 *
 * @author Daniel K Monaghan <dkm2@aber.ac.uk>
 * @version 1.0
*/ 
class SidebarNavigation {

	private $items = array();
	private $active_html = null;

	/**
	 * HTML to be inserted when a sidebar item is related to
	 * the current page
	 *
	 * @param string $html
	*/
	public function setActiveHTML($html){
		$this->active_html = $html;
	}

	/**
	 * Adds a new item to the navigation
	 *
	 * @param string $url
	 * @param string $text
	 */
	public function addItem($url, $text){
		$item = array(
			'text' => $text,
			'url' => $url
		);

		if ($url == WebInterface::$page){
			$item['active_html'] = $this->active_html;
		} else {
			$item['active_html'] = null;
		}

		$this->items[] = $item;
	}

	/** 
	 * Returns array of items currently inserted into
	 * the sidebar
	 * 
	 * @return array
	*/
	public function getItems(){
		return $this->items;
	}
}