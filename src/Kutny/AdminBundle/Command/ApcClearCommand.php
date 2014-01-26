<?php

namespace Kutny\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ApcClearCommand extends ContainerAwareCommand {

	protected function configure() {
		$this->setName('apc:clear')
			->setDescription('Clear apc cache');
	}

	/**
	 * @inheritdoc
	 */
	protected function execute(InputInterface $input, OutputInterface $output) {
		if (function_exists('apc_clear_cache')) {
			apc_clear_cache();
			$output->writeln('Apc cache cleared.');
		}
		else {
			$output->writeln('Apc cache cannot be deleted, because apc_clear_cache function does not exists. Check if you have apc installed locally.');
		}
	}

}
