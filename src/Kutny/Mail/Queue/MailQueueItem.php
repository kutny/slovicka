<?php

namespace Kutny\Mail\Queue;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Kutny\Mail\Queue\ItemState\MailQueueItemState;

/**
 * @ORM\Entity
 */
class MailQueueItem {

	/**
	 * @var integer
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	private $id;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=255, nullable=false)
	 */
	private $fromMail;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	private $fromName;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=255, nullable=false)
	 */
	private $toMail;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	private $toName;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=255, nullable=false)
	 */
	private $subject;

	/**
	 * @var string
	 * @ORM\Column(type="text", nullable=false)
	 */
	private $textBody;

	/**
	 * @var string
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $htmlBody;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	private $templateName;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $language;

	/**
	 * @var MailQueueItemState
	 * @ORM\ManyToOne(targetEntity="\Kutny\Mail\Queue\ItemState\MailQueueItemState")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $state;

	/**
	 * @var DateTime
	 * @ORM\Column(type="datetime", nullable=false)
	 */
	private $createdOn;

	/**
	 * @var DateTime
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $sentOn;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $replyToMail;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $replyToName;

	/**
	 * @var integer
	 * @ORM\Column(type="smallint", nullable=true)
	 */
	private $numberOfTrials;

	public function setCreatedOn(DateTime $createdOn) {
		$this->createdOn = $createdOn;
	}

	/** @return DateTime */
	public function getCreatedOn() {
		return $this->createdOn;
	}

	public function setFromMail($fromMail) {
		$this->fromMail = $fromMail;
	}

	public function getFromMail() {
		return $this->fromMail;
	}

	public function setFromName($fromName) {
		$this->fromName = $fromName;
	}

	public function getFromName() {
		return $this->fromName;
	}

	public function setHtmlBody($htmlBody) {
		$this->htmlBody = $htmlBody;
	}

	public function getHtmlBody() {
		return $this->htmlBody;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}

	public function setLanguage($language) {
		$this->language = $language;
	}

	public function getLanguage() {
		return $this->language;
	}

	public function setNumberOfTrials($numberOfTrials) {
		$this->numberOfTrials = $numberOfTrials;
	}

	public function getNumberOfTrials() {
		return $this->numberOfTrials;
	}

	public function setReplyToMail($replyToMail) {
		$this->replyToMail = $replyToMail;
	}

	public function getReplyToMail() {
		return $this->replyToMail;
	}

	public function setReplyToName($replyToName) {
		$this->replyToName = $replyToName;
	}

	public function getReplyToName() {
		return $this->replyToName;
	}

	public function setSentOn(DateTime $sentOn) {
		$this->sentOn = $sentOn;
	}

	public function getSentOn() {
		return $this->sentOn;
	}

	public function setTemplateName($templateName) {
		$this->templateName = $templateName;
	}

	public function getTemplateName() {
		return $this->templateName;
	}

	public function setState(MailQueueItemState $state) {
		$this->state = $state;
	}

	/** @return MailQueueItemState */
	public function getState() {
		return $this->state;
	}

	public function setSubject($subject) {
		$this->subject = $subject;
	}

	public function getSubject() {
		return $this->subject;
	}

	public function setTextBody($textBody) {
		$this->textBody = $textBody;
	}

	public function getTextBody() {
		return $this->textBody;
	}

	public function setToMail($toMail) {
		$this->toMail = $toMail;
	}

	public function getToMail() {
		return $this->toMail;
	}

	public function setToName($toName) {
		$this->toName = $toName;
	}

	public function getToName() {
		return $this->toName;
	}

}
