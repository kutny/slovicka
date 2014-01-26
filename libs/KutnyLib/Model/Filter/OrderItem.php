<?php

namespace KutnyLib\Model\Filter;

class OrderItem {

	private $position;
	private $ascending;

	public function __construct($position, $ascending) {
		$this->position = $position;
		$this->ascending = $ascending;
	}

	public function getPosition() {
		return $this->position;
	}

	public function isAscending() {
		return $this->ascending;
	}
}
