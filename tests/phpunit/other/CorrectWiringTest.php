<?php

use KutnyLib\PhpUnit\TestCase;
use KutnyLib\Yml\YmlSorter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

class CorrectWiringTest extends TestCase {

	/** @var YmlSorter $ymlSorter */
	private $ymlSorter;

	protected function setUp() {
		$this->ymlSorter = $this->getService('yml.yml_sorter');
	}

	/** @test */
	public function wiringOk() {
		global $container;
		$serviceDefinitions = $this->getServiceDefinitions();
		$parsedServiceDefinitions = Yaml::parse($serviceDefinitions)['services'];

		$container->enterScope('request');
		$container->set('request', new Request(), 'request');

		foreach (array_keys($parsedServiceDefinitions) as $serviceId) {
			$container->get($serviceId);
		}

		$this->assertTrue(true, 'Wiring OK');
	}

	private function getServiceDefinitions() {
		return file_get_contents($this->getParameter('service_container'));
	}
}
