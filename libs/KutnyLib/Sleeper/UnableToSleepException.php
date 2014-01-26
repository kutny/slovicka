<?php

namespace KutnyLib\Sleeper;

use InvalidArgumentException;

class UnableToSleepException extends InvalidArgumentException {

	public function __construct($message) {
		parent::__construct($message);
	}
}
