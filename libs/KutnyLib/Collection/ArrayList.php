<?php

namespace KutnyLib\Collection;

use ArrayAccess;
use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use Traversable;

class ArrayList implements IteratorAggregate, ArrayAccess, Countable {

	protected $items;

	public function __construct(array $items) {
		$this->items = $items;
	}

	public function getIterator() {
		return new ArrayIterator($this->items);
	}

	public function count() {
		return count($this->items);
	}

	public function isEmpty() {
		return ($this->count() === 0);
	}

	public function getItems() {
		return $this->items;
	}

	public function offsetGet($offset) {
		return $this->items[$offset];
	}

	public function offsetExists($offset) {
		return array_key_exists($offset, $this->items);
	}

	/**
	 * @inheritdoc
	 */
	public function offsetSet($offset, $value) {
		throw new \Exception('Not supported');
	}

	/**
	 * @inheritdoc
	 */
	public function offsetUnset($offset) {
		throw new \Exception('Not supported');
	}

	public function map(callable $mapCallback) {
		$extractedProperties = array();
		foreach ($this->items as $key => $item) {
			if ($item instanceof Pair) {
				$extractedProperties[] = $mapCallback($item->getFirst(), $item->getSecond());
			}
			else {
				$extractedProperties[] = $mapCallback($item, $key);
			}
		}
		return $extractedProperties;
	}

	public function flatMap(callable $mapCallback) {
		$mapped = new self($this->map($mapCallback));
		return $mapped->flatten();
	}

	public function flatten() {
		return $this->doFlatten($this->items);
	}

	private function doFlatten($items) {
		$flattened = [];
		if ($items instanceof Traversable || is_array($items)) {
			foreach ($items as $item) {
				$flattened = array_merge($flattened, $this->doFlatten($item));
			}
		}
		else {
			$flattened[] = $items;
		}
		return $flattened;
	}

	public function extractByKey($key) {
		return $this->map(function ($array) use ($key) {
			return $array[$key];
		});
	}

	public function extractUniqueByKey($key) {
		return array_unique($this->extractByKey($key));
	}

	public function uniqueMap(callable $mappingCallback) {
		$extractedItems = [];
		foreach ($this->items as $item) {
			$extractedItem = $mappingCallback($item);

			if (!in_array($extractedItem, $extractedItems)) {
				$extractedItems[] = $extractedItem;
			}
		}

		return $extractedItems;
	}

	public function filter(callable $filterCallback) {
		$filtered = array();
		foreach ($this->items as $item) {
			if ($filterCallback($item)) {
				$filtered[] = $item;
			}
		}
		return $filtered;
	}

	public function find(callable $findCallback) {
		foreach ($this->items as $item) {
			if ($findCallback($item)) {
				return $item;
			}
		}
		return null;
	}

	public function findAll(callable $findCallback) {
		$found = [];
		foreach ($this->items as $item) {
			if ($findCallback($item)) {
				$found[] = $item;
			}
		}
		return $found;
	}

	public function exists(callable $existsCallback) {
		return $this->find($existsCallback) !== null;
	}

	public function allMatchCondition(callable $matchCallback) {
		return !$this->isEmpty() && !$this->exists(function ($item) use ($matchCallback) {
			return !$matchCallback($item);
		});
	}

	public function reduceLeft($items, callable $reduceCallback) {
		if (!count($items)) {
			throw new CannotReduceException("Empty collection cannot be reduced");
		}
		$reduced = reset($items);
		while ($item = next($items)) {
			$reduced = $reduceCallback($reduced, $item);
		}

		return $reduced;
	}

	public function sort(callable $comparsionCallback) {
		$copied = $this->items;
		usort($copied, $comparsionCallback);
		return $copied;
	}

	public function zip(ArrayList $list) {
		if ($this->count() !== $list->count()) {
			throw new CannotZipException('Lists must have same length');
		}

		$zipped = array();
		$iterator = $list->getIterator();
		foreach ($this->items as $item) {
			$zipped[] = new Pair($item, $iterator->current());
			$iterator->next();
		}

		return new ArrayList($zipped);
	}

	public function index(callable $indexCallback) {
		$indexed = array();
		foreach ($this->items as $key => $item) {
			$pair = $indexCallback($item, $key);
			if (!($pair instanceof Pair)) {
				throw new InvalidArgumentException('Pair class expected');
			}
			$indexed[$pair->getFirst()] = $pair->getSecond();
		}
		return $indexed;
	}

	public function toArray() {
		return $this->items;
	}

	public function walk(callable $walkCallback, $result = null) {
		foreach ($this->items as $item) {
			$result = $walkCallback($result, $item);
		}

		return $result;
	}

	public function each(callable $eachCallback) {
		foreach ($this->items as $item) {
			$eachCallback($item);
		}
	}

	public function first() {
		return $this->find(function () {
			return true;
		});
	}

	public function removeNulls() {
		return $this->filter(function ($item) {
			return $item !== null;
		});
	}
}
