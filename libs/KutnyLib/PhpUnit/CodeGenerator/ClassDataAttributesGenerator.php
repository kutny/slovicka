<?php

namespace KutnyLib\PhpUnit\CodeGenerator;

use ReflectionClass;

class ClassDataAttributesGenerator {

	private $classNameToVariableNameConvertor;

	public function __construct(ClassNameToVariableNameConvertor $classNameToVariableNameConvertor) {
		$this->classNameToVariableNameConvertor = $classNameToVariableNameConvertor;
	}

	public function getCode(ReflectionClass $reflection) {
		return
			$this->getMocksDefinition($reflection) .
			$this->getBaseClassDataAttributeDefinition($reflection) .
			"\n";
	}

	private function getMocksDefinition(ReflectionClass $reflection) {
		$code = '';

		foreach ($reflection->getProperties() as $reflectionProperty) {
			$code .=
				"\t" . '/** @var \PHPUnit_Framework_MockObject_MockObject */' . "\n" .
				"\t" . 'private $' . $reflectionProperty->getName() . 'Mock;' . "\n\n";
		}

		return $code;
	}

	private function getBaseClassDataAttributeDefinition(ReflectionClass $reflection) {
		$code =
			"\t" . '/** @var ' . $reflection->getShortName() . ' */' . "\n" .
			"\t" . 'private $' . $this->classNameToVariableNameConvertor->convert($reflection->getShortName()) . ';' . "\n";

		return $code;
	}

}
