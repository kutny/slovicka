<?php

namespace KutnyLib\Model;

use KutnyLib\Model\QueryBuilderFilter\Join;
use KutnyLib\Model\QueryBuilderFilter\LeftJoin;
use KutnyLib\Model\QueryBuilderFilter\LeftJoinWith;
use KutnyLib\Model\QueryBuilderFilter\OrderItem;
use KutnyLib\Model\QueryBuilderFilter\JoinWith;

class QueryBuilderFilter {

	private $select;
	private $fromEntity;
	private $fromAlias;
	/** @var Join[] */
	private $joins;
	/** @var LeftJoin[] */
	private $leftJoins;
	/** @var LeftJoinWith[] */
	private $leftJoinsWith;
	private $conditions;
	private $groupBy;
	private $parameters;
	private $orderItems;
	private $limit;
	private $offset;

	public function __construct() {
		$this->joins = array();
		$this->leftJoins = array();
		$this->leftJoinsWith = array();
		$this->conditions = array();
		$this->parameters = array();
		$this->orderItems = array();
	}

	public function setSelect($select) {
		$this->select = $select;
	}

	public function setFrom($entity, $alias) {
		$this->fromEntity = $entity;
		$this->fromAlias = $alias;
	}

	public function addRawJoin(Join $join) {
		$this->joins[] = $join;
	}

	public function addJoin($entityClassName, $alias) {
		$this->joins[] = new Join($entityClassName, $alias);
	}

	public function addJoinWith($entityClassName, $alias, $withCondition) {
		$this->joins[] = new JoinWith($entityClassName, $alias, $withCondition);
	}

	public function addLeftJoin($entityClassName, $alias) {
		$this->joins[] = new LeftJoin($entityClassName, $alias);
	}

	public function addLeftJoinWith($entityClassName, $alias, $with) {
		$this->joins[] = new LeftJoinWith($entityClassName, $alias, $with);
	}

	public function addCondition($condition) {
		$this->conditions[] = $condition;
	}

	public function setParameter($name, $value) {
		$this->parameters[$name] = $value;
	}

	public function addOrderBy($attributeName, $position, $ascending) {
		$this->orderItems[] = new OrderItem($attributeName, $position, $ascending);
	}

	public function setLimit($limit) {
		$this->limit = $limit;
	}

	public function getSelect() {
		return $this->select;
	}

	public function getFromEntity() {
		return $this->fromEntity;
	}

	public function getFromAlias() {
		return $this->fromAlias;
	}

	public function getJoins() {
		return $this->joins;
	}

	public function getLeftJoins() {
		return $this->leftJoins;
	}

	public function getLeftJoinsWith() {
		return $this->leftJoinsWith;
	}

	public function getConditions() {
		return $this->conditions;
	}

	public function getParameters() {
		return $this->parameters;
	}

	public function getOrderItems() {
		return $this->orderItems;
	}

	public function getLimit() {
		return $this->limit;
	}

	public function setGroupBy($groupBy) {
		$this->groupBy = $groupBy;
	}

	public function getGroupBy() {
		return $this->groupBy;
	}

	public function setOffset($offset) {
		$this->offset = $offset;
	}

	public function getOffset() {
		return $this->offset;
	}
}
