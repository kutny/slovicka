<?php

namespace KutnyLib\Model\QueryBuilderFilter;

class Condition {

	private $condition;
	private $parameters;

	/**
	 * @param $condition
	 * @param Parameter[] $parameters
	 */
	public function __construct($condition, array $parameters = array()) {
		$this->condition = $condition;
		$this->parameters = $parameters;
	}

	public function getCondition() {
		return $this->condition;
	}

	/** @return Parameter[] */
	public function getParameters() {
		return $this->parameters;
	}

}
