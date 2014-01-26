<?php

namespace KutnyLib\Model;

use Doctrine\ORM\QueryBuilder;

interface IFilteredQueryBuilderFactory {

	/** @return QueryBuilder */
	function createQueryBuilder(QueryBuilderFilter $queryBuilderFilter);
}
