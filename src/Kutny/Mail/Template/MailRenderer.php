<?php

namespace Kutny\Mail\Template;

class MailRenderer {

	private $twigRenderer;

	public function __construct(
		\Twig_Environment $twigRenderer
	) {
		$this->twigRenderer = $twigRenderer;
	}

	public function render(FileTemplate $template, $partType) {
		$templatePath = $template->getTemplateFilePath($partType);

		if (!file_exists($templatePath)) {
			throw new \Exception('Template does not exist: ' . $templatePath);
		}

		$templateContent = file_get_contents($templatePath);

		return $this->twigRenderer->render($templateContent, $template->getVariables());
	}

}
