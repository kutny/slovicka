<?php

namespace KutnyLib\Model;

use KutnyLib\Model\Filter\Filter;
use KutnyLib\Model\QueryBuilderFilter;

interface IFilterConverter {

	public function getQueryBuilderFilter(Filter $filter);

}
