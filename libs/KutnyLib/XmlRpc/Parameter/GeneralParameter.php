<?php

namespace KutnyLib\XmlRpc\Parameter;

abstract class GeneralParameter {

	private $value;

	public function __construct($value) {
		$this->value = $value;
	}

	public function getValue() {
		return $this->value;
	}

	abstract public function getXmlFormatedValue();

}
