<?php

namespace Kutny\Mail\Queue;

use Kutny\Mail\Queue\Attachment\MailAttachmentRepository;
use Kutny\Mail\Queue\ItemState\MailQueueItemState;
use Kutny\Mail\Queue\ItemState\MailQueueItemStateFilter;
use Kutny\Mail\Queue\ItemState\MailQueueItemStateRepository;
use Kutny\Mail\Template\MailMessage2MailQueueItemConverter;
use KutnyLib\DateTime\DateTimeFactory;
use KutnyLib\Email\EmailAddress;
use KutnyLib\Mail\MailMessage;

class MailQueueFacade {

	private $dateTimeFactory;
	private $mailQueueRepository;
	private $mailQueueItemStateRepository;
	private $mailAttachmentRepository;
	private $mailMessage2MailQueueItemConverter;

	public function __construct(
		DateTimeFactory $dateTimeFactory,
		MailQueueRepository $mailQueueRepository,
		MailQueueItemStateRepository $mailQueueItemStateRepository,
		MailAttachmentRepository $mailAttachmentRepository,
		MailMessage2MailQueueItemConverter $mailMessage2MailQueueItemConverter
	) {
		$this->dateTimeFactory = $dateTimeFactory;
		$this->mailQueueRepository = $mailQueueRepository;
		$this->mailQueueItemStateRepository = $mailQueueItemStateRepository;
		$this->mailAttachmentRepository = $mailAttachmentRepository;
		$this->mailMessage2MailQueueItemConverter = $mailMessage2MailQueueItemConverter;
	}

	public function enqueueMailMessage(MailMessage $mailMessage, EmailAddress $from, EmailAddress $recipient, EmailAddress $replyTo = null) {
		$mailQueueItem = $this->mailMessage2MailQueueItemConverter->convert($mailMessage, $from, $recipient, $replyTo);

		$mailQueueItem->setState($this->getQueuedMailItemState());

		$this->mailQueueRepository->save($mailQueueItem);
	}

	public function getQueuedMailItemState() {
		$filter = new MailQueueItemStateFilter();
		$filter->setStateQueued();
		$queuedMailItemState = $this->mailQueueItemStateRepository->fetchSingle($filter);

		return $queuedMailItemState;
	}

	public function getListForProcessing($limit) {
		$filter = new MailQueueFilter();
		$filter->setStateIds(array(MailQueueItemState::ID_QUEUED, MailQueueItemState::ID_RETRY));
		$filter->addOrderByStateId(true);
		$filter->addOrderByCreatedOn(false);
		$filter->setLimit($limit);

		$list = $this->mailQueueRepository->fetchList($filter);
		return $list;
	}

	public function setItemSending(MailQueueItem $mailQueueItem) {
		$filter = new MailQueueItemStateFilter();
		$filter->setStateSending();
		$sentMailItemSending = $this->mailQueueItemStateRepository->fetchSingle($filter);

		$mailQueueItem->setState($sentMailItemSending);
		$this->mailQueueRepository->save($mailQueueItem);
	}

	public function setItemSent(MailQueueItem $mailQueueItem) {
		$filter = new MailQueueItemStateFilter();
		$filter->setStateSent();
		$sentMailItemState = $this->mailQueueItemStateRepository->fetchSingle($filter);

		$mailQueueItem->setState($sentMailItemState);
		$mailQueueItem->setSentOn($this->dateTimeFactory->getCurrentDateTime()->toDateTime());
		$this->mailQueueRepository->save($mailQueueItem);
	}

	public function setItemTried(MailQueueItem $mailQueueItem) {
		$filter = new MailQueueItemStateFilter();
		$filter->setStateRetry();
		$retryMailItemState = $this->mailQueueItemStateRepository->fetchSingle($filter);

		$mailQueueItem->setState($retryMailItemState);

		$trialCount = $mailQueueItem->getNumberOfTrials();
		if ($trialCount === null) {
			$newTrialCount = 1;
		}
		else {
			$newTrialCount = $trialCount + 1;
		}

		$mailQueueItem->setNumberOfTrials($newTrialCount);

		$this->mailQueueRepository->save($mailQueueItem);
	}

	public function setItemFailed(MailQueueItem $mailQueueItem) {
		$filter = new MailQueueItemStateFilter();
		$filter->setStateError();
		$errorMailItemState = $this->mailQueueItemStateRepository->fetchSingle($filter);
		$mailQueueItem->setState($errorMailItemState);

		$this->mailQueueRepository->save($mailQueueItem);
	}

	public function getItemTrialCount(MailQueueItem $mailQueueItem) {
		return $mailQueueItem->getNumberOfTrials();
	}

}
