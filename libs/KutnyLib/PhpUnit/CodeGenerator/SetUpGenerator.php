<?php

namespace KutnyLib\PhpUnit\CodeGenerator;

use ReflectionClass;

class SetUpGenerator {

	private $classNameToVariableNameConvertor;

	public function __construct(ClassNameToVariableNameConvertor $classNameToVariableNameConvertor) {
		$this->classNameToVariableNameConvertor = $classNameToVariableNameConvertor;
	}

	public function getCode(ReflectionClass $reflection) {
		$classVariableName = $this->classNameToVariableNameConvertor->convert($reflection->getShortName());
		$constructorArgumentsCode = $this->getConstructorArgumentsCode($reflection);

		$code = '';

		$code .=
			"\t" . 'public function setUp() {' . "\n" .
			"\t\t" . '/** @noinspection PhpParamsInspection */' . "\n" .
			"\t\t" . '$this->' . $classVariableName .' = new ' . $reflection->getShortName() . '(' . $constructorArgumentsCode . ');' . "\n";

		$code .= "\t" . '}';

		return $code;
	}

	private function getConstructorArgumentsCode(ReflectionClass $reflection) {
		if (!$reflection->getConstructor()) {
			return null;
		}

		$mockingMethodsCode = array();

		foreach ($reflection->getConstructor()->getParameters() as $parameter) {
			$mockingMethodsCode[] = "\t\t\t" . '$this->mock' . ucfirst($parameter->getName()) . '()';
		}

		return "\n" . implode(",\n", $mockingMethodsCode) . "\n" . "\t\t";
	}

}
