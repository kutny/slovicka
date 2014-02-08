<?php

namespace Kutny\User\Registration;

use Kutny\User\EmailUniqueConstraint;
use Symfony\Component\Validator\Constraints as Assert;

class Registration {

	/**
	 * @Assert\NotBlank()
	 */
	private $name;

	/**
	 * @Assert\NotBlank()
	 * @Assert\Email()
	 * @EmailUniqueConstraint()
	 */
	private $email;

	/**
	 * @Assert\NotBlank()
	 */
	private $password;

	public function setName($name) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function getEmail() {
		return $this->email;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	public function getPassword() {
		return $this->password;
	}

}
