<?php

namespace KutnyLib\Contact;

use KutnyLib\Validator\IValidator;

class PhoneNumberFormaterAndValidator implements IValidator {

	private $phoneNumberFormater;
	private $phoneNumberValidator;

	public function __construct(PhoneNumberFormater $phoneNumberFormater, PhoneNumberValidator $phoneNumberValidator) {
		$this->phoneNumberFormater = $phoneNumberFormater;
		$this->phoneNumberValidator = $phoneNumberValidator;
	}

	public function isValid($value) {
		$formatedPhoneNumber = $this->phoneNumberFormater->format($value);

		return $this->phoneNumberValidator->isValid($formatedPhoneNumber);
	}

}
