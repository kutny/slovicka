<?php

namespace KutnyLib\Application\Output;

class MemoryOutput implements IOutput {

	private $data;

	public function __construct() {
		$this->data = '';
	}

	public function write($s) {
		$this->data .= $s;
	}

	public function getWritten() {
		return $this->data;
	}

	public function writeln($s) {
		$this->write($s . PHP_EOL);
	}
}
