<?php

namespace KutnyLib\PhpUnit\CodeGenerator;

use ReflectionClass;

class MockBuildingMethodsGenerator {

	public function getCode(ReflectionClass $reflection) {
		if (!$reflection->getConstructor()) {
			return null;
		}

		$code = '';

		$parameters = $reflection->getConstructor()->getParameters();

		foreach ($parameters as $index => $parameter) {
			if ($this->argumentIsNotClass($parameter->getClass())) {
				continue;
			}

			$code .=
				"\t" . 'private function mock' . ucfirst($parameter->getName()) . '() {' . "\n" .
				$this->createMockDefinition($parameter->getName(), $parameter->getClass()->getName()) .
				"\n" .
				"\t\t" . 'return $this->' . $parameter->getName() . 'Mock;' . "\n" .
				"\t}";

			if (($index + 1) < count($parameters)) {
				$code .= "\n\n";
			}
		}

		return $code;
	}

	private function createMockDefinition($variableName, $variableClass) {
		return
			"\t\t" . '$this->' . $variableName . 'Mock = $this->getMockBuilder(\'' . $variableClass . '\')' . "\n" .
			"\t\t\t" . '->disableOriginalConstructor()' . "\n" .
			"\t\t\t" . '->getMock();' . "\n";
	}

	private function argumentIsNotClass($class) {
		return ($class === null);
	}

}
