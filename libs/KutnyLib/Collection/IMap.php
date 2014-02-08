<?php

namespace KutnyLib\Collection;

/** @codingStandardsIgnoreStart */
use Countable;
use IteratorAggregate;
/** @codingStandardsIgnoreEnd */

interface IMap extends Countable, IteratorAggregate {

	public function getKeys();
	public function getValues();
	public function getValue($key);
	public function isEmpty();
	public function exists($key);
	public function toArray(callable $getKeyCallback);
	public function map(callable $map);

	public function each(callable $map);
	/**
	 * @param callable $filterCallback
	 * @return static
	 */
	public function filter(callable $filterCallback);
	public function firstValue();
	public function firstKey();
	public function findInValues(callable $matchCallback);
	public function findInKeys(callable $matchCallback);

}
