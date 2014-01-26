<?php

namespace KutnyLib\Debug;

use Exception;
use Tracy\Debugger;

class TracyExceptionLogger {

	public function logException(Exception $exception) {
		Debugger::log($exception, Debugger::ERROR);
	}
}
