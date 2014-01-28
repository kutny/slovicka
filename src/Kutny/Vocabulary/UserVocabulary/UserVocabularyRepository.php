<?php

namespace Kutny\Vocabulary\UserVocabulary;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use KutnyLib\Model\Filter\Filter;
use KutnyLib\Model\FilteredQueryBuilderFactory;
use KutnyLib\Model\GeneralFilterConverter;

class UserVocabularyRepository {

	private $entityManager;
	private $filteredQueryBuilderFactory;
	private $filterConverter;

	public function __construct(
		EntityManager $entityManager,
		FilteredQueryBuilderFactory $filteredQueryBuilderFactory,
		GeneralFilterConverter $filterConverter
	) {
		$this->entityManager = $entityManager;
		$this->filteredQueryBuilderFactory = $filteredQueryBuilderFactory;
		$this->filterConverter = $filterConverter;
	}

	/** @return UserVocabulary */
	public function fetch(Filter $filter) {
		$queryBuilderFilter = $this->filterConverter->getQueryBuilderFilter($filter);
		$queryBuilder = $this->filteredQueryBuilderFactory->createQueryBuilder($queryBuilderFilter);

		try {
			return $queryBuilder->getQuery()->getSingleResult();
		}
		catch (NoResultException $e) {
			return null;
		}
	}

	/** @return UserVocabularyList */
	public function fetchList(Filter $filter) {
		return new UserVocabularyList($this->createFilteredQueryBuilder($filter)->getQuery()->getResult());
	}

	public function fetchCount(Filter $filter) {
		$queryBuilder = $this->createFilteredQueryBuilder($filter);
		$queryBuilder->select('COUNT(' . $filter->getAlias() . ')');
		$count = (int)$queryBuilder->getQuery()->getSingleScalarResult();
		return $count;
	}

	public function exists(Filter $filter) {
		$queryBuilder = $this->createFilteredQueryBuilder($filter);
		$queryBuilder->select('1');
		$queryBuilder->setMaxResults(1);

		return (bool) $queryBuilder->getQuery()->getOneOrNullResult();
	}

	public function save(UserVocabulary $entity) {
		$this->entityManager->persist($entity);
		$this->entityManager->flush($entity);
	}

	private function createFilteredQueryBuilder(Filter $filter) {
		$queryBuilderFilter = $this->filterConverter->getQueryBuilderFilter($filter);
		$queryBuilder = $this->filteredQueryBuilderFactory->createQueryBuilder($queryBuilderFilter);
		return $queryBuilder;
	}

}
