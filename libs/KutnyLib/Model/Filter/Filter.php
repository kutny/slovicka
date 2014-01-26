<?php

namespace KutnyLib\Model\Filter;

use KutnyLib\Model\QueryBuilderFilter\Condition;
use KutnyLib\Model\QueryBuilderFilter\Join;

abstract class Filter {

	private $limit;
	private $offset;
	private $conditions;
	private $joins = [];
	private $orderByAttributes = [];
	private $orderIndex = 0;

	public function setLimit($limit) {
		$this->limit = $limit;
	}

	public function getLimit() {
		return $this->limit;
	}

	public function setOffset($offset) {
		$this->offset = $offset;
	}

	public function getOffset() {
		return $this->offset;
	}

	/**
	 * @return Condition[]
	 */
	public function getConditions() {
		return $this->conditions;
	}

	/**
	 * @return Join[]
	 */
	public function getJoins() {
		return $this->joins;
	}

	public function addOrderBy($column, $asc = true) {
		$this->orderByAttributes[$column] = new OrderItem($this->orderIndex++, $asc);
	}

	/** @return OrderItem[] */
	public function getOrderByAttributes() {
		return $this->orderByAttributes;
	}

	abstract public function getEntityClass();

	abstract public function getAlias();

	protected function add(Condition $condition) {
		$this->conditions[] = $condition;
	}

	protected function addJoin(Join $join) {
		$this->joins[] = $join;
	}

}
