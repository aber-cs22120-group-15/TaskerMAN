<?php
namespace TaskerMAN\WebInterface;

/**
 * Enables generic generation of dropdowns on listings page
 *
 * @author Daniel K Monaghan <dkm2@aber.ac.uk>
 * @license GNU General Public License v3.0
*/
class GenericDropdownGenerator {

	/**
	 * Returns HTML for dropdown
	 *
	 * @param array $options
	 * @param mixed $selected Already selected option
	 * @return string HTML output
	*/
	static public function generate($options, $selected = null){

		$output = '';
				
		foreach ($options as $key => $string){

			$output .= '<option value="' . $key . '"';

			if ($key == $selected){
				$output .= ' selected';
			}

			$output .= '>' . $string . '</option>' . "\n";
		}

		return $output;
	}
}