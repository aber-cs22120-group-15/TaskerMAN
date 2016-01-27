<?php
namespace TaskerMAN\Core; 

/**
 * An assortion of mathematical functions used by the application
 *
 * @author Daniel K Monaghan <dkm2@aber.ac.uk>
 * @version 1.0
*/
class Math {
	
	/**
	 * Generates a UUID v4 token conforming to RFC 4122
	 *
	 * This function was inspired by code 
	 * found at https://github.com/j20/php-uuid/blob/master/src/J20/Uuid/Uuid.php
	 *
	 * @return string
	*/
	static public function GenerateUUIDv4(){
		$hex = bin2hex(openssl_random_pseudo_bytes(14));
		return strtoupper(sprintf('%s-%s-%s-%04x-%s',
			// 8 hex characters
			substr($hex, 0, 8),
			// 4 hex characters
			substr($hex, 8, 4),
			// "4" for the UUID version + 3 hex characters
			'4' . substr($hex, 12, 3),
			// (8, 9, a, or b) for the UUID variant + 3 hex characters
			mt_rand(0, 0x3fff) | 0x8000,
			// 12 hex characters
			substr($hex, 15, 12)
		));
	}
}