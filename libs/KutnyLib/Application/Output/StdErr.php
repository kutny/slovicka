<?php

namespace KutnyLib\Application\Output;

class StdErr extends FileOutput {

	public function  __construct() {
		parent::__construct('php://stderr', 'w');
	}
}
