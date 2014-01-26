<?php

namespace KutnyLib\Validator;

interface IValidator {

	/**
	 * @param mixed $value
	 * @returns boolean
	 */
	public function isValid($value);

}
