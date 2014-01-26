<?php

namespace Kutny\Dashboard;

use KutnyLib\Templating\FillLayout;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DashboardController {

	/**
	 * @Route("/", name="route.dashboard")
	 * @FillLayout(service="templating.layout_filler")
	 * @Template("@KutnyAdmin/Dashboard/dashboard.html.twig")
	 */
	public function dashboardAction() {
		return array();
	}

}
