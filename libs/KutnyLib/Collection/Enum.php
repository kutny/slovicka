<?php

namespace KutnyLib\Collection;

use InvalidArgumentException;
use ReflectionClass;

class Enum {

	private $value;

	private function __construct($value) {
		$this->value = $value;
	}

	public static function create($value) {
		if (!in_array($value, static::values())) {
			throw new InvalidArgumentException('Invalid value ' . $value . '. One of ' . implode(',', static::values()) . ' expected');
		}

		return new static($value);
	}

	public static function values() {
		$reflectionClass = new ReflectionClass(get_called_class());
		$values = $reflectionClass->getConstants();
		return $values;
	}

	public function getValue() {
		return $this->value;
	}

}
