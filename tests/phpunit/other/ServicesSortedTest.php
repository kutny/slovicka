<?php

use KutnyLib\PhpUnit\TestCase;
use KutnyLib\Yml\YmlSorter;
use Symfony\Component\Yaml\Yaml;

class ServicesSortedTest extends TestCase {

	/** @var YmlSorter $ymlSorter */
	private $ymlSorter;

	protected function setUp() {
		$this->ymlSorter = $this->getService('yml.yml_sorter');
	}

	/** @test */
	public function servicesSorted() {
		$serviceDefinitions = $this->getServiceDefinitions();
		$sortedServiceDefinitions = $this->ymlSorter->sort($serviceDefinitions);

		$parsedServiceDefinitions = Yaml::parse($serviceDefinitions)['services'];
		$parsedSortedServiceDefinitions = Yaml::parse($sortedServiceDefinitions)['services'];

		$this->assertSame(
			array_keys($parsedServiceDefinitions),
			array_keys($parsedSortedServiceDefinitions),
			'Services are not sorted'
		);
	}

	private function getServiceDefinitions() {
		return file_get_contents($this->getParameter('service_container'));
	}
}
