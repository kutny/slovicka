<?php

namespace KutnyLib\Model;

use KutnyLib\Model\Filter\Filter;
use KutnyLib\Model\QueryBuilderFilter;

class GeneralFilterConverter implements IFilterConverter {

	private $filterApplier;

	public function __construct(FilterApplier $filterApplier) {
		$this->filterApplier = $filterApplier;
	}

	public function getQueryBuilderFilter(Filter $filter) {
		$queryBuilderFilter = new QueryBuilderFilter();

		$queryBuilderFilter->setSelect($filter->getAlias());
		$queryBuilderFilter->setFrom($filter->getEntityClass(), $filter->getAlias());

		$this->filterApplier->applyJoins($filter, $queryBuilderFilter);
		$this->filterApplier->applyConditions($filter, $queryBuilderFilter);

		$this->filterApplier->applyLimit($filter, $queryBuilderFilter);
		$this->filterApplier->applyOffset($filter, $queryBuilderFilter);
		$this->filterApplier->applyOrderByColumns($filter, $queryBuilderFilter);

		return $queryBuilderFilter;
	}

}
