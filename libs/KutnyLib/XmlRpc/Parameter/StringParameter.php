<?php

namespace KutnyLib\XmlRpc\Parameter;

class StringParameter extends GeneralParameter {

	public function __construct($value) {
		parent::__construct((string) $value);
	}

	public function getXmlFormatedValue() {
		return '<string>' . $this->getValue() . '</string>';
	}

}
