<?php

namespace Kutny\Settings;

use KutnyLib\Templating\FillLayout;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SettingsController {

	/**
	 * @Route("/settings", name="route.settings")
	 * @FillLayout(service="templating.layout_filler")
	 * @Template("@KutnyAdmin/Settings/settings.html.twig")
	 */
	public function settingsAction() {
		return array();
	}

}
