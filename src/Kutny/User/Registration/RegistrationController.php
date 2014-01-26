<?php

namespace Kutny\User\Registration;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController {

	private $registrationFacade;
	private $router;
	private $formFactory;
	private $registrationForm;

	public function __construct(
		RegistrationFacade $registrationFacade,
		Router $router,
		FormFactory $formFactory,
		RegistrationForm $registrationForm
	) {
		$this->registrationFacade = $registrationFacade;
		$this->router = $router;
		$this->formFactory = $formFactory;
		$this->registrationForm = $registrationForm;
	}

	/**
	 * @Route("/registration", name="route.registration")
	 * @Template("@KutnyAdmin/Registration/registration.html.twig")
	 * @Method("GET")
	 */
	public function registrationAction() {
		$registration = new Registration();
		$form = $this->formFactory->create($this->registrationForm, $registration);

		return $this->createResponse($form);
	}

	/**
	 * @Route("/registration")
	 * @Template("@KutnyAdmin/Registration/registration.html.twig")
	 * @Method("POST")
	 */
	public function registrationPostAction(Request $request) {
		$registration = new Registration();
		$form = $this->formFactory->create($this->registrationForm, $registration);
		$form->submit($request);

		if ($form->isValid()) {
			$this->registrationFacade->createNewAccount($form->getData(), $request->getClientIp());

			return new RedirectResponse($this->router->generate('route.dashboard'));
		}
		else {
			return $this->createResponse($form);
		}
	}

	private function createResponse(Form $form) {
		return array(
			'registrationForm' => $form->createView()
		);
	}

}
