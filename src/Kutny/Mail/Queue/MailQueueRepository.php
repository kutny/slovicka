<?php

namespace Kutny\Mail\Queue;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Exception;

class MailQueueRepository {

	private $entityManager;

	public function __construct(EntityManager $entityManager) {
		$this->entityManager = $entityManager;
	}

	public function fetchList(MailQueueFilter $filter) {
		$query = $this->createQueryBuilder($filter)->getQuery();

		try {
			$result = $query->getResult();
		}
		catch (NoResultException $exception) {
			$result = array();
		}

		return $result;
	}

	public function save(MailQueueItem $mailQueueItem) {
		$this->entityManager->persist($mailQueueItem);
		$this->entityManager->flush();
	}

	/**
	 * @SuppressWarnings(PMD.CyclomaticComplexity)
	 * @SuppressWarnings(PMD.NPathComplexity)
	 * @SuppressWarnings(PMD.ExcessiveMethodLength)
	 */
	private function createQueryBuilder(MailQueueFilter $filter) {
		$queryBuilder = $this->entityManager->createQueryBuilder()
			->select('mailQueueItem')
			->from(MailQueueItem::class, 'mailQueueItem');

		$joins = array();

		if ($filter->getStateIds() !== null) {
			$queryBuilder->andWhere('mailQueueItemState.id IN (:stateIds)')
				->setParameter('stateIds', $filter->getStateIds());
		}

		if ($filter->getOrder()) {
			foreach ($filter->getOrder() as $orderItem) {
				$orderItemNames = array_keys($orderItem);
				$orderItemName = $orderItemNames[0];

				switch ($orderItemName) {
					case 'createdOn':
						$orderAttributeName = 'mailQueueItem.createdOn';
						break;
					case 'state.id':
						$joins[] = 'mailQueueItemState';
						$orderAttributeName = 'mailQueueItemState.id';
						break;
					default:
						throw new Exception('Unknown order item name \'' . $orderItemName . '\'');
				}

				$orderDirection = $orderItem[$orderItemName] ? 'ASC' : 'DESC';
				$queryBuilder->addOrderBy($orderAttributeName, $orderDirection);
			}
		}

		if ($filter->getLimit() !== null) {
			$queryBuilder->setMaxResults($filter->getLimit());
		}

		$joins = array_unique($joins);
		foreach ($joins as $join) {
			switch ($join) {
				case 'mailQueueItemState':
					$queryBuilder->join('mailQueueItem.state', 'mailQueueItemState');
					break;
				default:
					throw new Exception('Unknown join \'' . $join . '\'');
			}
		}

		return $queryBuilder;
	}
}
