<?php

namespace Kutny\User;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EmailUniqueValidator extends ConstraintValidator {

	private $userRepository;

	public function __construct(UserRepository $userRepository) {
		$this->userRepository = $userRepository;
	}

	public function validate($email, Constraint $constraint) {
		$filter = new UserFilter();
		$filter->setEmail($email);

		if ($this->userRepository->exists($filter)) {
			$this->context->addViolation('User with email ' . $email . ' already exist');
		}
	}

}
