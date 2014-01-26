<?php

namespace KutnyLib\PhpUnit;

abstract class DbTestCase extends TestCase {

	public function tearDown() {
		parent::tearDown();
		$this->unloadYmlFixtures();
	}

	public function setUp() {
		parent::setUp();
		$this->loadYmlFixtures($this->getYmlFixturesFile());
	}

	protected abstract function getYmlFixturesFile();

	protected function loadYmlFixtures($yamlFile) {
		$loader = $this->getService('bonami_lib.database.yaml_loader');
		$loader->loadYaml($yamlFile);
	}

	protected function unloadYmlFixtures() {
		$loader = $this->getService('bonami_lib.database.yaml_loader');
		$loader->unloadYaml();
	}

}
