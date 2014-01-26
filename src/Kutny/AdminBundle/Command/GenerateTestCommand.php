<?php

namespace Kutny\AdminBundle\Command;

use KutnyLib\PhpUnit\TestSkeletonGenerator;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateTestCommand extends ContainerAwareCommand {

	protected function configure() {
		$this->setName('generate:test')
			->setDescription('Generate PHPUnitTestCase')
			->addArgument('name', InputArgument::REQUIRED, 'What class we will test?');
	}

	/**
	 * @inheritdoc
	 * @SuppressWarnings(PMD.ExcessiveMethodLength)
	 */
	protected function execute(InputInterface $input, OutputInterface $output) {
		$name = $input->getArgument('name');

		/** @var TestSkeletonGenerator $testSkeletonGenerator */
		$testSkeletonGenerator = $this->getContainer()->get('phpunit.test_skeleton_generator');

		try {
			if (strpos($name, '.php')) {
				$name = str_replace(array('src/', 'libs/', '.php'), '', $name);
				$name = str_replace('/', '\\', $name);
				$code = $testSkeletonGenerator->generateFromClass($name);
			}
			else {
				$code = $testSkeletonGenerator->generateFromClass($name);
			}
		}
		catch (ReflectionException $e) {
			$output->writeln($e->getMessage());
			return;
		}

		$class = str_replace('\\', '/', $name);

		// Store File
		$dir = $this->getContainer()->get('kernel')->getRootDir();
		$dir .= '/../tests/phpunit/unit/';

		$path = $dir . implode('/', explode('/', $class, -1));
		if (!is_dir($path)){
			mkdir($path, 0777, true);
		}

		file_put_contents($dir . $class . 'Test.php', $code);
		$output->writeln($dir . $class . 'Test.php was created');
	}
}
