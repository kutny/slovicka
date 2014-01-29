<?php

namespace Kutny\Practising;

use KutnyLib\Templating\FillLayout;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PractisingController {

	/**
	 * @Route("/practising", name="route.practising")
	 * @FillLayout(service="templating.layout_filler")
	 * @Template("@KutnyAdmin/Practising/practising.html.twig")
	 */
	public function practisingAction() {
		return array();
	}

}
