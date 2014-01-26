<?php

namespace Kutny\AdminBundle\Command;

use Doctrine\Bundle\DoctrineBundle\ConnectionFactory;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RecreateDatabaseCommand extends ContainerAwareCommand {

	protected function configure() {
		$this->setName('database:recreate')
			->setDescription('Drop existing database (if exists) and creates a new one');
	}

	/**
	 * @inheritdoc
	 */
	protected function execute(InputInterface $input, OutputInterface $output) {
		if ($this->databaseAlreadyCreated()) {
			$command = $this->getApplication()->find('doctrine:database:drop');
			$command->run(new ArrayInput(array('command' => $command->getName(), '--force' => true)), $output);
		}

		$command = $this->getApplication()->find('doctrine:database:create');
		$command->run(new ArrayInput(array('command' => $command->getName())), $output);
	}

	private function databaseAlreadyCreated() {
		$dbName = $this->getContainer()->getParameter('database_name');

		$connection = $this->getConnection();

		return (bool) $connection->query('SHOW DATABASES LIKE ' . $connection->quote($dbName))->fetchColumn();
	}

	private function getConnection() {
		/** @var ConnectionFactory $connectionFactory */
		$connectionFactory = $this->getContainer()->get('doctrine.dbal.connection_factory');

		$connection = $connectionFactory->createConnection(array(
			'driver' => $this->getContainer()->getParameter('database_driver'),
			'user' => $this->getContainer()->getParameter('database_user'),
			'password' => $this->getContainer()->getParameter('database_password'),
			'host' => $this->getContainer()->getParameter('database_host'),
			'port' => $this->getContainer()->getParameter('database_port')
		));

		return $connection;
	}
}
