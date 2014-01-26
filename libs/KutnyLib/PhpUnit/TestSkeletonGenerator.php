<?php

namespace KutnyLib\PhpUnit;

use KutnyLib\PhpUnit\CodeGenerator\ClassDefinitionGenerator;
use ReflectionClass;

class TestSkeletonGenerator {

	private $classDefinitionGenerator;

	public function __construct(ClassDefinitionGenerator $classDefinitionGenerator) {
		$this->classDefinitionGenerator = $classDefinitionGenerator;
	}

	public function generateFromClass($className) {
		$reflection = new ReflectionClass($className);

		return $this->classDefinitionGenerator->getCode($reflection);
	}

}
