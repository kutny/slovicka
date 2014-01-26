<?php

namespace Kutny\User\Registration;

use Kutny\User\User;
use Kutny\User\UserRepository;
use KutnyLib\DateTime\DateTimeFactory;

class RegistrationFacade {

	private $bcryptIterations;
    private $dateTimeFactory;
    private $userRepository;
	private $welcomeEmailCreator;

	public function __construct(
		$bcryptIterations,
		DateTimeFactory $dateTimeFactory,
		UserRepository $userRepository,
		WelcomeEmailCreator $welcomeEmailCreator
	) {
		$this->bcryptIterations = $bcryptIterations;
		$this->dateTimeFactory = $dateTimeFactory;
		$this->userRepository = $userRepository;
		$this->welcomeEmailCreator = $welcomeEmailCreator;
	}

	/**
	 * @Transactional
	 */
	public function createNewAccount(Registration $registration, $ipAddress) {
		$user = $this->createNewPasswordUser($registration->getName(), $registration->getEmail(), $registration->getPassword(), $ipAddress);

		$this->welcomeEmailCreator->sendWelcomeEmail($user);

		return $user;
	}

	private function createNewPasswordUser($name, $email, $password, $ipAddress) {
		$user = new User($email);
		$user->setName($name);
		$user->setCreatedAt($this->dateTimeFactory->getCurrentDateTime()->toDateTime());
		$user->setRegistrationIpAddress($ipAddress);
		$user->setRole(User::ROLE_USER);

		if ($password) {
			$user->setPassword(password_hash($password, PASSWORD_BCRYPT, ['cost' => $this->bcryptIterations]));
		}

		$this->userRepository->save($user);

		return $user;
	}

}
