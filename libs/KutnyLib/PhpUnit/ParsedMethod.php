<?php

namespace KutnyLib\PhpUnit;

class ParsedMethod {

	private $name;
	private $arguments;

	public function __construct($name, $arguments) {
		$this->name = $name;
		$this->arguments = $arguments;
	}

	public function getArguments() {
		return $this->arguments;
	}

	public function getName() {
		return $this->name;
	}

}
