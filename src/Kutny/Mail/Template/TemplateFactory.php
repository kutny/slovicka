<?php

namespace Kutny\Mail\Template;

use Kutny\Mail\Message\HtmlMessageLayoutFiller;
use KutnyLib\Css\InlineStylesConverter;
use KutnyLib\Mail\MailMessage;

class TemplateFactory {

	private $mailRenderer;
	private $htmlMessageLayoutFiller;
	private $inlineStylesConverter;

	public function __construct(
		MailRenderer $mailRenderer,
		HtmlMessageLayoutFiller $htmlMessageLayoutFiller,
		InlineStylesConverter $inlineStylesConverter
	) {
		$this->mailRenderer = $mailRenderer;
		$this->htmlMessageLayoutFiller = $htmlMessageLayoutFiller;
		$this->inlineStylesConverter = $inlineStylesConverter;
	}

	public function create($name, $path, $language, array $variables = array()) {
		$fileTemplate = new FileTemplate($name, $path, $language, $this->htmlMessageLayoutFiller->setDefaultVariables($variables));

		$subject = $this->mailRenderer->render($fileTemplate, FileTemplate::PART_SUBJECT);
		$textBody = $this->mailRenderer->render($fileTemplate, FileTemplate::PART_TEXT);
		$htmlBody = $this->mailRenderer->render($fileTemplate, FileTemplate::PART_HTML);

		if ($htmlBody) {
			$htmlBody = $this->inlineStylesConverter->convert($htmlBody);
		}

		return new MailMessage($subject, $textBody, $htmlBody, $language, $name);
	}
}
