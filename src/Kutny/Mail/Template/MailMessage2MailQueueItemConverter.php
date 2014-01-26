<?php

namespace Kutny\Mail\Template;

use Kutny\Mail\Queue\MailQueueItem;
use KutnyLib\DateTime\DateTimeFactory;
use KutnyLib\Email\EmailAddress;
use KutnyLib\Mail\MailMessage;

class MailMessage2MailQueueItemConverter {

	private $dateTimeFactory;

	public function __construct(DateTimeFactory $dateTimeFactory) {
		$this->dateTimeFactory = $dateTimeFactory;
	}

	public function convert(MailMessage $mailMessage, EmailAddress $from, EmailAddress $recipient, EmailAddress $replyTo = null) {
		$mailQueueItem = new MailQueueItem();

		$mailQueueItem->setFromMail($from->getAddress());
		$mailQueueItem->setFromName($from->getName());

		$mailQueueItem->setToMail($recipient->getAddress());
		$mailQueueItem->setToName($recipient->getName());

		if ($replyTo) {
			$mailQueueItem->setReplyToMail($replyTo->getAddress());
			$mailQueueItem->setReplyToName($replyTo->getName());
		}

		$mailQueueItem->setSubject($mailMessage->getSubject());
		$mailQueueItem->setTextBody($mailMessage->getTextBody());
		$mailQueueItem->setHtmlBody($mailMessage->getHtmlBody());

		$mailQueueItem->setTemplateName($mailMessage->getTemplateName());
		$mailQueueItem->setLanguage($mailMessage->getLanguage());
		$mailQueueItem->setCreatedOn($this->dateTimeFactory->getCurrentDateTime()->toDateTime());

		return $mailQueueItem;
	}

}
