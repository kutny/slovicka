<?php

namespace KutnyLib\Contact;

use KutnyLib\Validator\IValidator;

class EmailValidator implements IValidator {

	public function isValid($value) {
		return (bool) filter_var($value, FILTER_VALIDATE_EMAIL);
	}

}
