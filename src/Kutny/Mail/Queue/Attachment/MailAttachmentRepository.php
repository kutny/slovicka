<?php

namespace Kutny\Mail\Queue\Attachment;

use Doctrine\ORM\EntityManager;

class MailAttachmentRepository {

	private $entityManager;

	public function __construct(EntityManager $entityManager) {
		$this->entityManager = $entityManager;
	}

	public function save(MailAttachment $mailAttachment) {
		$this->entityManager->persist($mailAttachment);
		$this->entityManager->flush();
	}
}
