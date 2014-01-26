<?php

namespace KutnyLib\Email;

use Symfony\Component\Validator\Constraints as Assert;

class EmailAddress {

	/**
	 * @Assert\Email()
	 */
	private $address;
	private $name;

	public function __construct($address, $name = null) {
		$this->address = $address;
		$this->name = $name;
	}

	public function getAddress() {
		return $this->address;
	}

	public function getName() {
		return $this->name;
	}
}
