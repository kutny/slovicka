<?php

namespace KutnyLib\Templating;

use Symfony\Bundle\TwigBundle\TwigEngine;

class TemplateRenderer {

	private $layoutFiller;
	private $twigEngine;

	public function __construct(ILayoutFiller $layoutFiller, TwigEngine $twigEngine) {
		$this->layoutFiller = $layoutFiller;
		$this->twigEngine = $twigEngine;
	}

	public function renderResponse($templateName, array $variables = array()) {
		return $this->twigEngine->renderResponse(
			$templateName,
			$this->layoutFiller->setDefaultVariables($variables)
		);
	}

}
