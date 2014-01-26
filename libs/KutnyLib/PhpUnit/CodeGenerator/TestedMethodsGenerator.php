<?php

namespace KutnyLib\PhpUnit\CodeGenerator;

use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;

class TestedMethodsGenerator {

	private $classNameToVariableNameConvertor;

	public function __construct(ClassNameToVariableNameConvertor $classNameToVariableNameConvertor) {
		$this->classNameToVariableNameConvertor = $classNameToVariableNameConvertor;
	}

	public function getCode(ReflectionClass $reflection) {
		$methodsCode = array();

		foreach ($reflection->getMethods() as $method) {
			/** @var ReflectionMethod $method */
			if (!$method->isPublic() || $method->isConstructor()) {
				continue;
			}

			$arguments = array();

			foreach ($method->getParameters() as $parameter) {
				/** @var ReflectionParameter $parameter */
				$arguments[] = '$' . $parameter->getName();
			}

			$methodsCode[] =
				"\t" . '/** @test */' . "\n" .
				"\t" . 'public function ' . $method->getName() . '() {' . "\n" .
				"\t\t" . '// TODO: test this method' . "\n" .
				$this->generateMethodArguments($arguments) . "\n" .
				"\t\t" . '$expectedResult = null;' . "\n" .
				"\n" .
				$this->generateTestedMethod($reflection, $method, $arguments) . "\n" .
				"\n" .
				"\t\t" . '$this->assertSame($expectedResult, $result);' . "\n" .
				"\t" . '}' . "\n";
		}

		return implode("\n", $methodsCode);
	}
	
	private function generateMethodArguments(array $arguments) {
		$code = '';

		foreach ($arguments as $argument) {
			$code .= "\t\t" . $argument . ' = null;' . "\n";
		}

		return $code;
	}

	private function generateTestedMethod(ReflectionClass $reflection, ReflectionMethod $method, array $arguments) {
		$testedClassPropertyName = $this->classNameToVariableNameConvertor->convert($reflection->getShortName());

		$code =
			"\t\t" . '$result = $this->' . $testedClassPropertyName . '->' . $method->getName() . '(' . "\n" .
			"\t\t\t" . implode(",\n" . "\t\t\t", $arguments) . "\n" .
			"\t\t" . ');';

		return $code;
	}

}
