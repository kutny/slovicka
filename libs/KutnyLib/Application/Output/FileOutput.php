<?php

namespace KutnyLib\Application\Output;

class FileOutput implements IOutput {

	private $handle;

	protected function __construct($path, $mode) {
		$this->openFile($path, $mode);
	}

	public function write($s) {
		fwrite($this->handle, (string)$s);
	}

	private function openFile($path, $mode) {
		$this->handle = fopen($path, $mode);
	}

	private function closeFile() {
		fclose($this->handle);
	}

	public function __destruct() {
		$this->closeFile();
	}

	public function writeln($s) {
		$this->write($s . PHP_EOL);
	}

}
