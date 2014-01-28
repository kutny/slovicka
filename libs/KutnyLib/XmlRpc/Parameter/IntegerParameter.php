<?php

namespace KutnyLib\XmlRpc\Parameter;

class IntegerParameter extends GeneralParameter {

	public function __construct($value) {
		parent::__construct((int) $value);
	}

	public function getXmlFormatedValue() {
		return '<int>' . $this->getValue() . '</int>';
	}

}
