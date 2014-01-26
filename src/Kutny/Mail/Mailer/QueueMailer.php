<?php

namespace Kutny\Mail\Mailer;

use Exception;
use Kutny\Mail\Queue\MailQueueFacade;
use Kutny\User\User;
use KutnyLib\Email\EmailAddress;
use KutnyLib\Mail\MailMessage;

class QueueMailer {

	private $defaultFrom;
	private $mailQueueFacade;

	public function __construct(
		EmailAddress $defaultFrom,
		MailQueueFacade $mailQueueFacade
	) {
		$this->defaultFrom = $defaultFrom;
		$this->mailQueueFacade = $mailQueueFacade;
	}

	public function sendToUser(MailMessage $mailMessage, User $recipientUser, EmailAddress $replyTo = null, EmailAddress $from = null) {
		if (!$recipientUser->getActive()) {
			throw new Exception('User ' . $recipientUser->getId() . ' is inactive');
		}

		$recipientName = strlen($recipientUser->getName()) ? $recipientUser->getName() : null;
		$recipient = new EmailAddress($recipientUser->getEmail(), $recipientName);

		$this->sendToAddress($mailMessage, $recipient, $replyTo, $from);
	}

	public function sendToAddress(MailMessage $mailMessage, EmailAddress $recipient, EmailAddress $replyTo = null, EmailAddress $from = null) {
		$from = $from !== null ? $from : $this->defaultFrom;

		$this->mailQueueFacade->enqueueMailMessage($mailMessage, $from, $recipient, $replyTo);
	}
}
