<?php

namespace Kutny\Vocabulary\UserVocabulary;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use KutnyLib\DateTime\Date;
use KutnyLib\Model\Filter\Filter;
use KutnyLib\Model\FilteredQueryBuilderFactory;
use KutnyLib\Model\GeneralFilterConverter;
use PDO;

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

	public function getRandomUserVocabularyId($userId, $correctAnswersLimit) {
		$connection = $this->entityManager->getConnection();

		return $connection->query('
			SELECT
				id
			FROM
				user_vocabulary
			WHERE
				user_id = ' . $connection->quote($userId) . '
				AND correct_answers < ' . $connection->quote($correctAnswersLimit) . '
				AND (last_correct_answer_at IS NULL OR last_correct_answer_at < CURDATE() OR correct_answers = 0)
			ORDER BY
				RAND()
			LIMIT
				1
		')->fetchColumn();
	}

	public function getAddedVocabularyStatsByDate($userId, Date $startDate) {
		$connection = $this->entityManager->getConnection();

		return $connection->query('
			SELECT
				DATE(created_at) AS day,
				COUNT(*) as newVocabularyCount
			FROM
				user_vocabulary
			WHERE
				user_id = ' . $connection->quote($userId) . '
				AND created_at >= ' . $connection->quote($startDate->toFormat('Y-m-d')) . '
			GROUP BY
				DATE(created_at)
			ORDER BY
				created_at ASC
		')->fetchAll(PDO::FETCH_KEY_PAIR);
	}

	public function getAddedVocabularySumBeforeDate($userId, Date $beforeDate) {
		$connection = $this->entityManager->getConnection();

		return $connection->query('
			SELECT
				COUNT(*)
			FROM
				user_vocabulary
			WHERE
				user_id = ' . $connection->quote($userId) . '
				AND created_at < ' . $connection->quote($beforeDate->toFormat('Y-m-d')) . '
		')->fetchColumn();
	}

	public function getLearnedVocabularyStatsByDate($userId, $correctAnswerLimit, Date $startDate) {
		$connection = $this->entityManager->getConnection();

		return $connection->query('
			SELECT
				DATE(last_correct_answer_at) AS day,
				COUNT(*) as learnedVocabularyCount
			FROM
				user_vocabulary
			WHERE
				user_id = ' . $connection->quote($userId) . '
				AND correct_answers >= ' . $connection->quote($correctAnswerLimit) . '
				AND last_correct_answer_at >= ' . $connection->quote($startDate->toFormat('Y-m-d')) . '
			GROUP BY
				DATE(last_correct_answer_at)
			ORDER BY
				last_correct_answer_at ASC
		')->fetchAll(PDO::FETCH_KEY_PAIR);
	}

	public function getLearnedVocabularySumBeforeDate($userId, $correctAnswerLimit, Date $beforeDate) {
		$connection = $this->entityManager->getConnection();

		return $connection->query('
			SELECT
				COUNT(*)
			FROM
				user_vocabulary
			WHERE
				user_id = ' . $connection->quote($userId) . '
				AND correct_answers >= ' . $connection->quote($correctAnswerLimit) . '
				AND last_correct_answer_at < ' . $connection->quote($beforeDate->toFormat('Y-m-d')) . '
		')->fetchColumn();
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
