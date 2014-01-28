<?php

namespace Kutny\Translator;

use KutnyLib\Templating\FillLayout;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TranslatorController {

	/**
	 * @Route("/translator", name="route.translator")
	 * @FillLayout(service="templating.layout_filler")
	 * @Template("@KutnyAdmin/Translator/translator.html.twig")
	 */
	public function translatorAction() {
		return array();
	}

}
