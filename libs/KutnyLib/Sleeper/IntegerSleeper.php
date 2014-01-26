<?php

namespace KutnyLib\Sleeper;

class IntegerSleeper implements ISleeper {

	public function sleep($length) {
		$length = (float)$length;
		if (false !== strpos((string)$length, '.')) {
			throw new UnableToSleepException('Given length \'' . $length . '\' is not an integer');
		}
		sleep($length);
	}
}
