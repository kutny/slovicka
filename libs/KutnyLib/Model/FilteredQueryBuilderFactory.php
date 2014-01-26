<?php

namespace KutnyLib\Model;

use Doctrine\ORM\EntityManager;

class FilteredQueryBuilderFactory implements IFilteredQueryBuilderFactory {

	private $entityManager;
	private $queryBuilderFilterApplier;

	public function __construct(EntityManager $entityManager, QueryBuilderFilterApplier $queryBuilderFilterApplier) {
		$this->entityManager = $entityManager;
		$this->queryBuilderFilterApplier = $queryBuilderFilterApplier;
	}

	public function createQueryBuilder(QueryBuilderFilter $queryBuilderFilter) {
		$queryBuilder = $this->entityManager->createQueryBuilder();
		$this->queryBuilderFilterApplier->apply($queryBuilderFilter, $queryBuilder);
		return $queryBuilder;
	}
}
