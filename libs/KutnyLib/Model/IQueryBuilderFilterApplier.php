<?php

namespace KutnyLib\Model;

use Doctrine\ORM\QueryBuilder;

interface IQueryBuilderFilterApplier {

	function apply(QueryBuilderFilter $filter, QueryBuilder $queryBuilder);
}
