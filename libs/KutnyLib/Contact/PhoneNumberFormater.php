<?php

namespace KutnyLib\Contact;

use KutnyLib\Formater\IFormater;
use KutnyLib\String\WhitespacesRemover;

class PhoneNumberFormater implements IFormater {

	private $whitespacesRemover;

	public function __construct(WhitespacesRemover $whitespacesRemover) {
		$this->whitespacesRemover = $whitespacesRemover;
	}

	public function format($value) {
		return $this->whitespacesRemover->removeWhitespaces($value);
	}

}
