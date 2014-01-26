<?php

namespace Kutny\User\Registration;

use Kutny\Mail\Mailer\QueueMailer;
use Kutny\Mail\Template\TemplateFactory;
use Kutny\User\User;

class WelcomeEmailCreator {

	private $templateFactory;
	private $mailer;

	public function __construct(
		TemplateFactory $templateFactory,
		QueueMailer $mailer
	) {
		$this->templateFactory = $templateFactory;
		$this->mailer = $mailer;
	}

	public function sendWelcomeEmail(User $user) {
		$mailVariables = array(
			'name' => $user->getName()
		);

		$mailMessage = $this->templateFactory->create('welcomeEmail', __DIR__ . '/WelcomeEmailCreator' , 'cs', $mailVariables);

		$this->mailer->sendToUser($mailMessage, $user);
	}

}
