<?php

namespace Kutny\Vocabulary;

use KutnyLib\Templating\FillLayout;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class OverviewController {

	/**
	 * @Route("/vocabulary", name="route.vocabulary")
	 * @FillLayout(service="templating.layout_filler")
	 * @Template("@KutnyAdmin/Vocabulary/overview.html.twig")
	 */
	public function overviewAction() {
		return array();
	}

}
