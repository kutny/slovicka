<?php

namespace Kutny\Mail\Message;

use KutnyLib\Templating\ILayoutFiller;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class HtmlMessageLayoutFiller implements ILayoutFiller {

	private $router;

	public function __construct(
		Router $router
	) {
		$this->router = $router;
	}

	public function setDefaultVariables(array $variables) {
		$variables['dashboardUrl'] = $this->router->generate('route.dashboard');

		return $variables;
	}
}
