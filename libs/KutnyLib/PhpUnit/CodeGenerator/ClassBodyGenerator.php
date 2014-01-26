<?php

namespace KutnyLib\PhpUnit\CodeGenerator;

use ReflectionClass;

class ClassBodyGenerator {

	private $classDataAttributesGenerator;
	private $setUpGenerator;
	private $testedMethodsGenerator;
	private $mockBuildingMethodsGenerator;
	private $expectationsGenerator;

	public function __construct(
		ClassDataAttributesGenerator $classDataAttributesGenerator,
		SetUpGenerator $setUpGenerator,
		TestedMethodsGenerator $testedMethodsGenerator,
		MockBuildingMethodsGenerator $mockBuildingMethodsGenerator,
		ExpectationsGenerator $expectationsGenerator
	) {
		$this->classDataAttributesGenerator = $classDataAttributesGenerator;
		$this->setUpGenerator = $setUpGenerator;
		$this->testedMethodsGenerator = $testedMethodsGenerator;
		$this->mockBuildingMethodsGenerator = $mockBuildingMethodsGenerator;
		$this->expectationsGenerator = $expectationsGenerator;
	}

	public function getCode(ReflectionClass $reflection) {
		return
			$this->classDataAttributesGenerator->getCode($reflection) .
			$this->setUpGenerator->getCode($reflection) . "\n" .
			"\n" .
			$this->testedMethodsGenerator->getCode($reflection) . "\n" .
			$this->expectationsGenerator->getCode($reflection) . "\n" .
			$this->mockBuildingMethodsGenerator->getCode($reflection);
	}

}
