<?php

namespace Kutny\User;

use Kutny\FixturesBundle\ISampleDataApplier;
use Kutny\User\Registration\Registration;
use Kutny\User\Registration\RegistrationFacade;
use Symfony\Component\Console\Output\OutputInterface;

class UserSampleDataApplier implements ISampleDataApplier {

	private $registrationFacade;

	public function __construct(
		RegistrationFacade $registrationFacade
	) {
		$this->registrationFacade = $registrationFacade;
	}

	public function apply(OutputInterface $output) {
		$this->createAccount1($output);
		$this->createAccount2($output);
	}

	private function createAccount1(OutputInterface $output) {
		$ipAddress = '127.0.0.1';
		$registration = $this->createRegistrationObject('Jiří Koutný', 'jirkakoutny@gmail.com', 'heslo123');

		$this->createAccount($registration, $ipAddress, $output);
	}

	private function createAccount2(OutputInterface $output) {
		$ipAddress = '84.42.201.139';
		$registration = $this->createRegistrationObject('Hanka Kmecová', 'hanka.kmecova@gmail.com', 'heslo123');

		$this->createAccount($registration, $ipAddress, $output);
	}

	private function createRegistrationObject($name, $email, $password) {
		$registration = new Registration();
		$registration->setName($name);
		$registration->setEmail($email);
		$registration->setPassword($password);

		return $registration;
	}

	private function createAccount(Registration $registration, $ipAddress, OutputInterface $output) {
		$output->writeln('Creating account');
		$account = $this->registrationFacade->createNewAccount($registration, $ipAddress);

		return $account;
	}

}
