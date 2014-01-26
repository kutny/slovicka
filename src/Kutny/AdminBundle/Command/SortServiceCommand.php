<?php

namespace Kutny\AdminBundle\Command;

use KutnyLib\Yml\YmlSorter;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SortServiceCommand extends ContainerAwareCommand {

	protected function configure() {
		$this->setName('services:sort')
			->setDescription('Sorts servicesin services.yml')
			->addArgument('className', InputOption::VALUE_REQUIRED,	'Full class name to create the service from');
	}

	/**
	 * @inheritdoc
	 */
	protected function execute(InputInterface $input, OutputInterface $output) {
		/** @var YmlSorter $ymlSorter */
		$ymlSorter = $this->getContainer()->get('yml.yml_sorter');
		$yml = file_get_contents($this->getContainer()->getParameter('service_container'));
		$yml = $ymlSorter->sort($yml);
		file_put_contents($this->getContainer()->getParameter('service_container'), $yml);
	}
}
