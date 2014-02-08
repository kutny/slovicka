<?php

namespace Kutny\Mail\Queue\MailSender;

use Kutny\Mail\Queue\MailQueueItem;
use Swift_Mailer;
use Swift_Message;

class SmtpMailSender implements IMailSender {

	private $swiftMailer;

	public function __construct(Swift_Mailer $swiftMailer) {
		$this->swiftMailer = $swiftMailer;
	}

	public function send(MailQueueItem $mailQueueItem) {
		$message = Swift_Message::newInstance();

		$message->setSubject($mailQueueItem->getSubject());
		$message->setFrom($mailQueueItem->getFromMail(), $mailQueueItem->getFromName());
		$message->setTo($mailQueueItem->getToMail(), $mailQueueItem->getToName());
		$message->setBody($mailQueueItem->getTextBody());

		if ($mailQueueItem->getHtmlBody()) {
			$message->addPart($mailQueueItem->getHtmlBody(), 'text/html');
		}

		if ($mailQueueItem->getReplyToMail()) {
			$message->setReplyTo($mailQueueItem->getReplyToMail(), $mailQueueItem->getReplyToName());
		}

		$this->swiftMailer->send($message);
	}

}
