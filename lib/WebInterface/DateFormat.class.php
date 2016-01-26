<?php
namespace TaskerMAN\WebInterface;

class DateFormat {

	static private $increments = array(
		'years' => 31556926,
		'months' => 2629743,
		'weeks' => 604800,
		'days' => 86400,
		'hours' => 3600,
		'minutes' => 60,
		'seconds' => 1
	);

	// Number of visible increments
	const TO_DISPLAY = 2;

	static public function timeDifference($compare, $short = false){
		$to = time();
		
		if((string)$compare != (string)(int)$compare){
			$compare = @strtotime($compare);

			if ($compare == false || $compare == -1){
				return false;
			}
		}
				
		if ($to > $compare){
			return self::timeFormat(abs($to - $compare), $short) . ' ago';
		} else {
			return self::timeFormat(abs($to - $compare), $short);
		}

	}

	static public function timeFormat($time, $short = false){

		$diff = array(
			'years' => 0,
			'months' => 0,
			'weeks' => 0,
			'days' => 0,
			'hours' => 0,
			'minutes' => 0,
			'seconds' => 0,
		);
				
		$i = 0;
		foreach (self::$increments as $type => $value){

			// Limit to just two visible increments
			if ($i >= self::TO_DISPLAY){
				break;
			}

			if($time >= $value){
				$i++;
				$diff[$type] = floor($time / $value);
				$time = $time % $value;
			}

		}

		if ($i == 0){ // Too close to measure
			return 'Just a moment';
		}
				
		$times = array();
		foreach($diff as $unit => $amount){

			if($amount == 0 || empty($amount)){
				continue;
			}

			if ($short){
				$suffix = $unit[0];
			} else {
				$suffix = ' ' . (abs($amount) == 1 ? substr($unit, 0, strlen($unit) - 1) : $unit);
			}

			$times[] = $amount . $suffix;
		}

		return str_replace('-', '', implode(' ', $times));
	}
}