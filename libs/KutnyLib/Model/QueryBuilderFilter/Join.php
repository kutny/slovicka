<?php

namespace KutnyLib\Model\QueryBuilderFilter;

class Join {

	private $entityClassName;
	private $alias;

	public function __construct($entityClassName, $alias) {
		$this->entityClassName = $entityClassName;
		$this->alias = $alias;
	}

	public function getEntityClassName() {
		return $this->entityClassName;
	}

	public function getAlias() {
		return $this->alias;
	}
}
