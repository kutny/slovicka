<?php

namespace Kutny\Mail\Queue;

use KutnyLib\Application\IRunnable;
use KutnyLib\Sleeper\ISleeper;

class MailQueueDaemon implements IRunnable {

	const LIMIT_PER_RUN = 20;
	const SLEEP_EMPTY_QUEUE = 15;
	const SLEEP_BETWEEN_EMAILS = 0;

	private $mailQueueFacade;
	private $mailSender;
	private $sleeper;

	public function __construct(
		MailQueueFacade $mailQueueFacade,
		MailSender $mailSender,
		ISleeper $sleeper
	) {
		$this->mailQueueFacade = $mailQueueFacade;
		$this->mailSender = $mailSender;
		$this->sleeper = $sleeper;
	}

	public function run() {
		$mailQueueItems = $this->mailQueueFacade->getListForProcessing(self::LIMIT_PER_RUN);

		if ($mailQueueItems) {
			$this->processItems($mailQueueItems);
		}
		else {
			$this->sleeper->sleep(self::SLEEP_EMPTY_QUEUE);
		}
	}

	private function processItems(array $mailQueueItems) {
		foreach ($mailQueueItems as $mailQueueItem) {
			$this->mailSender->send($mailQueueItem);
			$this->sleeper->sleep(self::SLEEP_BETWEEN_EMAILS);
		}
	}
}
