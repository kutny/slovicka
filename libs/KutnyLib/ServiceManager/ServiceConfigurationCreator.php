<?php

namespace KutnyLib\ServiceManager;

use KutnyLib\String\Camel2UnderscoreConverter;
use KutnyLib\Yml\YmlSorter;
use Symfony\Component\Console\Output\OutputInterface;

class ServiceConfigurationCreator {

	private $pathToServiceConfig;
	private $camel2UnderscoreConverter;
	private $ymlSorter;

	public function __construct(
		$pathToServiceConfig,
		Camel2UnderscoreConverter $camel2UnderscoreConverter,
		YmlSorter $ymlSorter
	) {
		$this->pathToServiceConfig = $pathToServiceConfig;
		$this->camel2UnderscoreConverter = $camel2UnderscoreConverter;
		$this->ymlSorter = $ymlSorter;
	}

	public function createService($fullClassName, OutputInterface $output) {
		if (!class_exists($fullClassName))
			throw new ClassDoesNotExistsException($fullClassName . ' does not exists.');

		$serviceName = $this->formatServiceName($fullClassName);

		$ymlData = file_get_contents($this->pathToServiceConfig);
		$ymlData = $this->updateServiceConfiguration($fullClassName, $serviceName, $ymlData, $output);

		file_put_contents($this->pathToServiceConfig, $ymlData);
	}

	public function formatServiceName($serviceName) {
		$shortcuts = array(
			'kutny.admin_bundle.controller' => 'controller',
			'kutny.admin_bundle' => 'kutny.admin',
			'kutny_lib.' => '',
			'kutny.' => ''
		);

		$serviceName = $this->camel2UnderscoreConverter->convert($serviceName);
		$serviceName = str_replace('\\_', '.', $serviceName);
		$serviceName = str_replace(array_keys($shortcuts), array_values($shortcuts), $serviceName);
		return $serviceName;
	}

	private function updateServiceConfiguration($fullClassName, $serviceName, $ymlData, OutputInterface $output) {
		if (!$this->isServiceDefinedInYml($serviceName, $ymlData)) {
			$ymlData = $this->addServiceToYml($serviceName, $fullClassName, $ymlData);

			$ymlData = $this->ymlSorter->sort($ymlData);

			$output->writeln('<info>Service added: ' . $serviceName . '</info>');
		}
		else {
			$output->writeln('<error>Service already defined: ' . $serviceName . '</error>');
		}

		return $ymlData;
	}

	private function addServiceToYml($serviceName, $fullClassName, $ymlData) {
		$ymlData .= "\n" . '  ' . $serviceName . ':'. "\n" . '    ' . 'class: ' . $fullClassName . "\n";

		return $ymlData;
	}

	private function isServiceDefinedInYml($serviceName, $ymlData) {
		return (strpos($ymlData, ' ' . $serviceName . ':') > 0);
	}

}
