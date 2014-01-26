<?php

namespace Kutny\Mail\Queue\ItemState;

use Kutny\FixturesBundle\IFixturesApplier;
use Symfony\Component\Console\Output\OutputInterface;

class MailQueueItemStateFixturesApplier implements IFixturesApplier {

	private $mailQueueItemStateRepository;

	public function __construct(MailQueueItemStateRepository $mailQueueItemStateRepository) {
		$this->mailQueueItemStateRepository = $mailQueueItemStateRepository;
	}

	public function apply(OutputInterface $output) {
		$states = [
			MailQueueItemState::ID_QUEUED => 'queued',
			MailQueueItemState::ID_SENDING => 'sending',
			MailQueueItemState::ID_RETRY => 'retry',
			MailQueueItemState::ID_SENT => 'sent',
			MailQueueItemState::ID_ERROR => 'error'
		];

		$output->writeln('Inserting mail queue item states');
		
		foreach ($states as $stateId => $stateName) {
			$mailQueueItemState = $this->getMailQueueItemState($stateId, $stateName);

			$this->mailQueueItemStateRepository->save($mailQueueItemState);
		}
	}
	
	private function getMailQueueItemState($id, $name) {
		$entity = new MailQueueItemState();
		$entity->setId($id);
		$entity->setName($name);
		
		return $entity;
	}

}
