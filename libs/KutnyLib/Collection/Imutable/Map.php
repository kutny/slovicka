<?php

namespace KutnyLib\Collection\Imutable;

use ArrayIterator;
use KutnyLib\Collection\IMap;
use KutnyLib\Collection\Pair;

class Map implements IMap {

	private $keys;
	private $values;

	public function __construct(array $items) {
		$this->keys = [];
		$this->values = [];

		foreach ($items as $keyValueArray) {
			list($key, $value) = $keyValueArray;
			$this->put($key, $value);
		};
	}

	protected function put($key, $value) {
		$keyHash = $this->hashKey($key);
		$this->keys[$keyHash] = $key;
		$this->values[$keyHash] = $value;
	}

	public function getKeys() {
		return $this->keys;
	}

	public function getValues() {
		$values = [];
		foreach ($this->getKeys() as $key) {
			$values[] = $this->getValue($key);
		}

		return $values;
	}

	public function getValue($key) {
		return $this->values[$this->hashKey($key)];
	}

	public function getIterator() {
		return new ArrayIterator($this->values);
	}

	public function count() {
		return count($this->values);
	}

	public function isEmpty() {
		return ($this->count() === 0);
	}

	public function exists($key) {
		return isset($this->values[$this->hashKey($key)]);
	}

	public function toArray(callable $getKeyCallback) {
		$array = [];
		foreach ($this->keys as $key) {
			$array[$getKeyCallback($key)] = $this->getValue($key);
		}

		return $array;
	}

	public function map(callable $mapCallback) {
		$mappedItems = array();
		foreach ($this->getKeys() as $key) {
			$value = $this->getValue($key);
			$mapped = $mapCallback($value, $key);
			if ($mapped instanceof Pair) {
				$mappedItems[] = [$mapped->getFirst(), $mapped->getSecond()];
			}
			else {
				$mappedItems[] = $mapped;
			}
		}
		return $mappedItems;
	}

	public function each(callable $eachCallback) {
		foreach ($this->getKeys() as $key) {
			$value = $this->getValue($key);
			$eachCallback($value, $key);
		}
	}

	public function filter(callable $filterCallback) {
		$filtered = array();
		foreach ($this->getKeys() as $key) {
			$value = $this->getValue($key);
			if ($filterCallback($value, $key)) {
				$filtered[] = [$key, $value];
			}
		}
		return new static($filtered);
	}

	public function firstKey() {
		return $this->findInKeys(function () {
			return true;
		});
	}

	public function firstValue() {
		return $this->findInValues(function () {
			return true;
		});
	}

	public function findInValues(callable $matchCallback) {
		foreach ($this->getKeys() as $key) {
			$value = $this->getValue($key);
			if ($matchCallback($value)) {
				return $value;
			}
		}
		return null;
	}

	public function findInKeys(callable $matchCallback) {
		foreach ($this->getKeys() as $key) {
			if ($matchCallback($key)) {
				return $key;
			}
		}
		return null;
	}

	private function hashKey($key) {
		return is_object($key) ? spl_object_hash($key) : $key;
	}

}
