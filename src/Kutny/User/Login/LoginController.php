<?php

namespace Kutny\User\Login;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class LoginController {

	/**
	 * @Route("/login", name="route.login")
	 * @Template("@KutnyAdmin/Login/login.html.twig")
	 */
	public function loginAction(Request $request) {
		if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
			$error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
		}
		else {
			$error = $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
		}

		return array(
			'last_username' => $request->getSession()->get(SecurityContext::LAST_USERNAME),
			'error' => $error
		);
	}
}
