<?php

namespace KutnyLib\Mail;

class MailMessage {

	private $subject;
	private $textBody;
	private $htmlBody;
	private $language;
	private $templateName;

	public function __construct($subject, $textBody, $htmlBody = null, $language = null, $templateName = null) {
		$this->subject = $subject;
		$this->textBody = $textBody;
		$this->htmlBody = $htmlBody;
		$this->language = $language;
		$this->templateName = $templateName;
	}

	public function getHtmlBody() {
		return $this->htmlBody;
	}

	public function getSubject() {
		return $this->subject;
	}

	public function getTextBody() {
		return $this->textBody;
	}

	public function getLanguage() {
		return $this->language;
	}

	public function getTemplateName() {
		return $this->templateName;
	}

}
