<?php

namespace KutnyLib\Model\QueryBuilderFilter;

class OrderItem {

	private $attributeName;
	private $position;
	private $ascending;

	public function __construct($attributeName, $position, $ascending) {
		$this->attributeName = $attributeName;
		$this->position = $position;
		$this->ascending = $ascending;
	}

	public function getAttributeName() {
		return $this->attributeName;
	}

	public function getPosition() {
		return $this->position;
	}

	public function isAscending() {
		return $this->ascending;
	}
}
