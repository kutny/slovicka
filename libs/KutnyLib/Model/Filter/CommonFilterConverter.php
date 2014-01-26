<?php

namespace KutnyLib\Model\Filter;

use KutnyLib\Model\QueryBuilderFilter;

class CommonFilterConverter {

	protected function applyLimit(Filter $filter, QueryBuilderFilter $queryBuilderFilter) {
		if ($filter->getLimit()) {
			$queryBuilderFilter->setLimit($filter->getLimit());
		}
	}

	protected function applyOffset(Filter $filter, QueryBuilderFilter $queryBuilderFilter) {
		if ($filter->getOffset()) {
			$queryBuilderFilter->setOffset($filter->getOffset());
		}
	}

}
