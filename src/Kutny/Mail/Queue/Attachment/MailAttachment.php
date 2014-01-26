<?php

namespace Kutny\Mail\Queue\Attachment;

use Doctrine\ORM\Mapping as ORM;
use Kutny\Mail\Queue\MailQueueItem;

/**
 * @ORM\Entity()
 */
class MailAttachment {

	/**
	 * @var integer
	 * @ORM\Column(type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	private $id;

	/**
	 * @var MailQueueItem
	 * @ORM\ManyToOne(targetEntity="\Kutny\Mail\Queue\MailQueueItem")
	 */
	private $mailQueueItem;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=255, nullable=false)
	 */
	private $name;

	/**
	 * @var string
	 * @ORM\Column(type="blob", nullable=false)
	 */
	private $content;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=255, nullable=false)
	 */
	private $contentType;

	public function setContent($content) {
		$this->content = $content;
	}

	public function getContent() {
		return $this->content;
	}

	public function setContentType($contentType) {
		$this->contentType = $contentType;
	}

	public function getContentType() {
		return $this->contentType;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}

	public function setMailQueueItem(MailQueueItem $mailQueueItem) {
		$this->mailQueueItem = $mailQueueItem;
	}

	/** @return MailQueueItem */
	public function getMailQueueItem() {
		return $this->mailQueueItem;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

}
