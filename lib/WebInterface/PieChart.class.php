<?php
namespace TaskerMAN\WebInterface;

/**
 * Generates pastel colours for each part of a pie chart
 *
 * @author Daniel K Monaghan <dkm2@aber.ac.uk>
 * @version 1.0
*/ 
class PieChart {

	/**
	 * Returns an array containing a colour and a highlighted colour 
	 * for use as a slice of a pie chart. Colour is based on $seed
	 *
	 * @param int $seed
	 * @return array
	*/
	static public function generatePastelColours($seed = null){

		// Set the random number generator to a static seed
		mt_srand($seed);

		$r = mt_rand(0, 255);
		$g = mt_rand(0, 255);
		$b = mt_rand(0, 255);

		// Reset random number generator to a random seed
		mt_srand();

		$r = floor(($r + 255) / 2);
		$g = floor(($g + 255) / 2);
		$b = floor(($b + 255) / 2);

		return array(
			'color' => 'rgba(' . $r . ', ' . $g . ', ' . $b . ', 1)',
			'highlight' => 'rgba(' . $r . ', ' . $g . ', ' . $b . ', 0.75)'
		);
	}

}