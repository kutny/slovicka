<?php

namespace Kutny\Auth;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Session {

	/**
	 * @ORM\Id
	 * @ORM\Column(type="string")
	 */
	private $id;

	/**
	 * @ORM\Column(type="text")
	 */
	private $value;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $time;

	public function setId($id) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}

	public function setTime($time) {
		$this->time = $time;
	}

	public function getTime() {
		return $this->time;
	}

	public function setValue($value) {
		$this->value = $value;
	}

	public function getValue() {
		return $this->value;
	}

}
