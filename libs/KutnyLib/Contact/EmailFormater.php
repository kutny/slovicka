<?php

namespace KutnyLib\Contact;

use KutnyLib\Formater\IFormater;

class EmailFormater implements IFormater {

	public function format($value) {
		$value = preg_replace('~\+[^@]+@~', '@', $value);

		return $value;
	}

}
