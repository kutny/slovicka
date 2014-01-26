<?php

namespace KutnyLib\Application\Output;

class StdOut extends FileOutput {

	public function __construct() {
		parent::__construct('php://stdout', 'w');
	}
}
