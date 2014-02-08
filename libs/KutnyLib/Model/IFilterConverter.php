<?php

namespace KutnyLib\Model;

use KutnyLib\Model\Filter\Filter;

interface IFilterConverter {

	public function getQueryBuilderFilter(Filter $filter);

}
