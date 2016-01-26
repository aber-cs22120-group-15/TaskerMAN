<?php
namespace TaskerMAN\WebInterface;


class SidebarNavigation {

	private $items = array();
	private $active_html = null;

	public function setActiveHTML($html){
		$this->active_html = $html;
	}

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

	public function getItems(){
		return $this->items;
	}
}