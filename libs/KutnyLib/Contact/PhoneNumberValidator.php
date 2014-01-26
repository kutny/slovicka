<?php

namespace KutnyLib\Contact;

use KutnyLib\Validator\IValidator;

class PhoneNumberValidator implements IValidator {

	public function isValid($value) {
		return (bool) preg_match('~[\d+]+~', $value);
	}

}
