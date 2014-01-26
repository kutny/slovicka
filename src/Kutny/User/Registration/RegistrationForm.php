<?php

namespace Kutny\User\Registration;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationForm extends AbstractType {

	/**
	 * @inheritdoc
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', 'text');
		$builder->add('email', 'text');
		$builder->add('password', 'password');
		$builder->add('save', 'submit');
	}

	public function getName() {
		return 'registrationForm';
	}
}
