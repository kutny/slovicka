<?php

namespace Kutny\User;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class EmailUniqueConstraint extends Constraint {

	public function validatedBy() {
		return 'user_email_unique_validator';
	}

}
