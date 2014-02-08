<?php

namespace KutnyLib\Contact;

use Exception;
use KutnyLib\Parser\IParser;

class PhoneNumberParser implements IParser {

	private $phoneNumberFormater;

	public function __construct(PhoneNumberFormater $phoneNumberFormater) {
		$this->phoneNumberFormater = $phoneNumberFormater;
	}

	public function parse($value) {
		$value = $this->phoneNumberFormater->format($value);

		$countryCodes = $this->getCountryCodes();

		if (preg_match('~^(?:\+|00)(' . implode('|', $countryCodes) . ')(.+)$~', $value, $matches)) {
			return new PhoneNumber($matches[1], $matches[2]);
		}
		else if (preg_match('~^(?:\+|00)~', $value)) {
			throw new Exception('Unexpected coutry code in phone number: ' . $value);
		}
		else {
			return new PhoneNumber(null, $value);
		}
	}

	private function getCountryCodes() {
		return [
			'CZ' => '420',
			'SK' => '421',
			'PL' => '48',
			'DE' => '49',
			'AT' => '43'
		];
	}

}
