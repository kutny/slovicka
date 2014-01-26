<?php

namespace Kutny\Mail\Queue\MailSender;

use Kutny\Mail\Queue\MailQueueItem;

interface IMailSender {

	public function send(MailQueueItem $mailQueueItem);

}
