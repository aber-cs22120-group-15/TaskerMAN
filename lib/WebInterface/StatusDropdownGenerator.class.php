<?php
namespace TaskerMAN\WebInterface;

/**
 * Enables generation of dropdowns on listings page
 *
 * @author Daniel K Monaghan <dkm2@aber.ac.uk>
 * @license GNU General Public License v3.0
*/
class StatusDropdownGenerator {

	/**
	 * Returns HTML for dropdown
	 *
	 * @param int $selected Already selected status
	 * @return string HTML output
	*/
	static public function generate($selected = null){

		$output = '';
		
		$statuses = array(0 => 'Abandoned', 1 => 'Allocated', 2 => 'Completed');
		
		foreach ($statuses as $status => $string){
			$output .= '<option value="' . $status . '"';

			if ($status == $selected && !is_null($selected)){
				$output .= ' selected';
			}

			$output .= '>' . $string . '</option>' . "\n";
		}

		return $output;
	}

}