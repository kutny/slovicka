<?php

namespace KutnyLib\Model;

use KutnyLib\Model\Filter\Filter;

class FilterApplier {

	public function applyJoins(Filter $filter, QueryBuilderFilter $queryBuilderFilter) {
		$joins = $filter->getJoins();

		foreach ($joins as $join) {
			$queryBuilderFilter->addRawJoin($join);
		}
	}

	public function applyConditions(Filter $filter, QueryBuilderFilter $queryBuilderFilter) {
		$conditions = $filter->getConditions();

		foreach ($conditions as $condition) {
			$queryBuilderFilter->addCondition($condition->getCondition());

			foreach ($condition->getParameters() as $parameter) {
				$queryBuilderFilter->setParameter($parameter->getName(), $parameter->getValue());
			}
		}
	}

	public function applyLimit(Filter $filter, QueryBuilderFilter $queryBuilderFilter) {
		if ($filter->getLimit()) {
			$queryBuilderFilter->setLimit($filter->getLimit());
		}
	}

	public function applyOffset(Filter $filter, QueryBuilderFilter $queryBuilderFilter) {
		if ($filter->getOffset()) {
			$queryBuilderFilter->setOffset($filter->getOffset());
		}
	}

	public function applyOrderByColumns(Filter $filter, QueryBuilderFilter $queryBuilderFilter) {
		$orderByColumns = $filter->getOrderByAttributes();

		foreach ($orderByColumns as $attribute => $orderItem) {
			$queryBuilderFilter->addOrderBy($attribute, $orderItem->getPosition(), $orderItem->isAscending());
		}
	}

}
