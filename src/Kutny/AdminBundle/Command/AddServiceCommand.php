<?php

namespace Kutny\AdminBundle\Command;

use KutnyLib\ServiceManager\ClassDoesNotExistsException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AddServiceCommand extends ContainerAwareCommand {

	protected function configure() {
		$this->setName('services:add')
			->setDescription('Add service to services.yml')
			->addArgument('service', InputOption::VALUE_REQUIRED, 'Full class name to create the service from');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$name = $input->getArgument('service');

		$serviceConfigurationCreator = $this->getContainer()->get('service.service_configuration_creator');
		try {
			if (strpos($name, '.php')) {
				$name = str_replace(array('src/', 'libs/', '.php'), '', $name);
				$name = str_replace('/', '\\', $name);
				$serviceConfigurationCreator->createService($name, $output);
			}
			else {
				$serviceConfigurationCreator->createService($name, $output);
			}

		}
		catch (ClassDoesNotExistsException $e) {
			$output->writeln('Class ' . $name . ' not found.');
		}
	}
}
