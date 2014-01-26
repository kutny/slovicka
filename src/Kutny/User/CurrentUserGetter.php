<?php

namespace Kutny\User;

use Symfony\Component\Security\Core\SecurityContext;

class CurrentUserGetter {

	private $securityContext;
	private $userRepository;

	public function __construct(SecurityContext $securityContext, UserRepository $userRepository) {
		$this->securityContext = $securityContext;
		$this->userRepository = $userRepository;
	}

	public function getUserEntity() {
		$user = $this->securityContext->getToken()->getUser();

		if ($user instanceof User) {
			return $this->getUserById($user->getId());
		}

		return null;
	}

	private function getUserById($userId) {
		$userFilter = new UserFilter();
		$userFilter->setId($userId);

		return $this->userRepository->fetch($userFilter);
	}

}
