<?php

namespace Kutny\Mail\Queue;

use Exception;
use Kutny\Mail\Queue\MailSender\IMailSender;
use KutnyLib\Debug\TracyExceptionLogger;
use KutnyLib\Sleeper\ISleeper;

class MailSender {

	const SLEEP_ITEM_SENT = 2;
	const SLEEP_ITEM_ERROR = 10;

	private $maxRetryCount;
	private $mailSender;
	private $sleeper;
	private $mailQueueFacade;
	private $exceptionLogger;

	public function  __construct(
		$maxRetryCount,
		IMailSender $mailSender,
		ISleeper $sleeper,
		MailQueueFacade $mailQueueFacade,
		TracyExceptionLogger $exceptionLogger
	) {
		$this->maxRetryCount = $maxRetryCount;
		$this->mailSender = $mailSender;
		$this->sleeper = $sleeper;
		$this->mailQueueFacade = $mailQueueFacade;
		$this->exceptionLogger = $exceptionLogger;
	}

	public function send(MailQueueItem $mailQueueItem) {
		$this->mailQueueFacade->setItemSending($mailQueueItem);

		try {
			$this->mailSender->send($mailQueueItem);
			$failed = false;
		}
		catch (Exception $exception) {
			$failed = true;
			$this->exceptionLogger->logException($exception);
		}

		if ($failed) {
			$this->processMailerException($mailQueueItem);
			$this->sleeper->sleep(self::SLEEP_ITEM_ERROR);
		}
		else {
			$this->mailQueueFacade->setItemSent($mailQueueItem);
			$this->sleeper->sleep(self::SLEEP_ITEM_SENT);
		}
	}

	private function processMailerException(MailQueueItem $mailQueueItem) {
		if ($this->mailQueueFacade->getItemTrialCount($mailQueueItem) < $this->maxRetryCount) {
			$this->mailQueueFacade->setItemTried($mailQueueItem);
		}
		else {
			$this->mailQueueFacade->setItemFailed($mailQueueItem);
		}
	}
}
