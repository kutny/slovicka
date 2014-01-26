<?php

namespace Kutny\Mail\Queue\ItemState;

use Doctrine\ORM\EntityManager;

class MailQueueItemStateRepository {

	private $entityManager;

	public function __construct(EntityManager $entityManager) {
		$this->entityManager = $entityManager;
	}

	public function fetchSingle(MailQueueItemStateFilter $filter) {
		$query = $this->createQueryBuilder($filter)->getQuery();
		$result = $query->getSingleResult();
		return $result;
	}

	/**
	 * @SuppressWarnings(PMD.CyclomaticComplexity)
	 * @SuppressWarnings(PMD.NPathComplexity)
	 * @SuppressWarnings(PMD.ExcessiveMethodLength)
	 */
	private function createQueryBuilder(MailQueueItemStateFilter $filter) {
		$queryBuilder = $this->entityManager->createQueryBuilder()
			->select('mailQueueItemState')
			->from(MailQueueItemState::class, 'mailQueueItemState');

		$states = array();
		if ($filter->getStateQueued()) {
			$states[] = MailQueueItemState::ID_QUEUED;
		}

		if ($filter->getStateSending()) {
			$states[] = MailQueueItemState::ID_SENDING;
		}

		if ($filter->getStateSent()) {
			$states[] = MailQueueItemState::ID_SENT;
		}

		if ($filter->getStateRetry()) {
			$states[] = MailQueueItemState::ID_RETRY;
		}

		if ($filter->getStateError()) {
			$states[] = MailQueueItemState::ID_ERROR;
		}

		if ($states) {
			$queryBuilder->andWhere('mailQueueItemState.id IN (:ids)')
				->setParameter('ids', $states);
		}

		return $queryBuilder;
	}

	public function save(MailQueueItemState $mailQueueItemState) {
		$this->entityManager->persist($mailQueueItemState);
		$this->entityManager->flush();
	}
}
