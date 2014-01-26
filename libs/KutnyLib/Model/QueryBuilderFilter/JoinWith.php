<?php

namespace KutnyLib\Model\QueryBuilderFilter;

class JoinWith extends Join {

	private $withCondition;

	public function __construct($entityClassName, $alias, $withCondition) {
		parent::__construct($entityClassName, $alias);
		$this->withCondition = $withCondition;
	}

	public function getWithCondition() {
		return $this->withCondition;
	}
}
