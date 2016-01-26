<?php
namespace TaskerMAN\WebInterface;

/**
 * Enables generation of dropdowns on listings page
 *
 * @author Daniel K Monaghan <dkm2@aber.ac.uk>
 * @license GNU General Public License v3.0
*/
class UserListDropdownGenerator {


	/**
	 * Returns HTML for dropdown
	 * @param int $selected Already selected uid
	 * @return string HTML output
	*/
	static public function generate($selected = null){
		$query = new \TaskerMAN\Core\DBQuery("SELECT
			`users`.`id`,
			`users`.`name`

			FROM `users`

			ORDER BY `users`.`name` ASC
		");

		$query->execute();

		while ($row = $query->row()){
			$output .= '<option value="' . $row['id'] . '"';

			if ($row['id'] == $selected){
				$output .= ' selected';
			}

			$output .= '>' . $row['name'] . '</option>' . "\n";
		}

		return $output;

	}

}