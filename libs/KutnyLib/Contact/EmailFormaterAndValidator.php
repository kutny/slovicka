<?php

namespace KutnyLib\Contact;

use KutnyLib\Validator\IValidator;

class EmailFormaterAndValidator implements IValidator {

	private $emailValidator;
	private $emailFormater;

	public function __construct(EmailValidator $emailValidator, EmailFormater $emailFormater) {
		$this->emailValidator = $emailValidator;
		$this->emailFormater = $emailFormater;
	}

	public function isValid($value) {
		return (bool) filter_var($value, FILTER_VALIDATE_EMAIL);
	}

}
