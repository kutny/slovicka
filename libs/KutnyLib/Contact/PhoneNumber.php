<?php

namespace KutnyLib\Contact;

class PhoneNumber {

	private $countryCode;
	private $phoneNumber;

	public function __construct($countryCode, $phoneNumber) {
		$this->countryCode = $countryCode;
		$this->phoneNumber = $phoneNumber;
	}

	public function getCountryCode() {
		return $this->countryCode;
	}

	public function getPhoneNumber() {
		return $this->phoneNumber;
	}

}
