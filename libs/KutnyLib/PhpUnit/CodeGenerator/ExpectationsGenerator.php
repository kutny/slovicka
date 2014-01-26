<?php

namespace KutnyLib\PhpUnit\CodeGenerator;

use KutnyLib\PhpUnit\MethodParser;
use KutnyLib\PhpUnit\ParsedMethod;
use KutnyLib\Reflection\MethodCodeExporter;
use ReflectionClass;
use ReflectionMethod;

/**
 * @SuppressWarnings(PMD.ExcessiveMethodLength)
 */
class ExpectationsGenerator {

	private $methodCodeExporter;
	private $methodParser;

	public function __construct(MethodCodeExporter $methodCodeExporter, MethodParser $methodParser) {
		$this->methodCodeExporter = $methodCodeExporter;
		$this->methodParser = $methodParser;
	}

	public function getCode(ReflectionClass $reflection) {
		$methods = array();

		foreach ($reflection->getMethods() as $method) {
			/** @var ReflectionMethod $method */
			if (!$method->isPublic() || $method->isConstructor()) {
				continue;
			}

			$methods[] = $method;
		}

		$code = $this->getMethodExpectationsCode($methods, $reflection);

		return $code;
	}

	private function getMethodExpectationsCode(array $methods, ReflectionClass $reflection) {
		$code = '';

		foreach ($methods as $method) {
			/** @var ReflectionMethod $method */
			$methodCode = $this->methodCodeExporter->getMethodCode($method);

			$parsedMethods = array();

			foreach ($reflection->getProperties() as $property) {
				if ($this->methodParser->propertyMethodCallExistsInPhpCode($property->getName(), $methodCode)) {
					$parsedMethods[$property->getName()] = $this->methodParser->findPropertyMethodInCode($property->getName(), $methodCode);
				}
			}

			if (count($parsedMethods) === 0) {
				continue;
			}
			else if (count($methods) === 1) {
				$expectationsMethodName = 'setExpectations';
			}
			else {
				$expectationsMethodName = 'setExpectations' . ucfirst($method->getName());
			}

			$code =
				"\t" . 'private function ' . $expectationsMethodName . '() {' . "\n" .
					$this->getDataAttributes($parsedMethods) . "\n" .
					"\t" . '}' . "\n";
		}

		return $code;
	}

	/**
	 * @param ParsedMethod[] $parsedMethods
	 * @return string
	 */
	private function getDataAttributes(array $parsedMethods) {
		$propertiesCode = '';

		foreach ($parsedMethods as $propertyName => $parsedMethod) {
			if (count($parsedMethod->getArguments()) > 0) {
				$withClause = "\t\t\t" . '->with(' . implode(', ', $parsedMethod->getArguments()) . ')' . "\n";
			}
			else {
				$withClause = '';
			}

			/** @var ParsedMethod $parsedMethod */
			$propertiesCode[] =
				"\t\t" . '$this->' . $propertyName . 'Mock->expects($this->once())' . "\n" .
				"\t\t\t" . '->method(\'' . $parsedMethod->getName() . '\')' . "\n" .
				$withClause .
				"\t\t\t" . '->will($this->returnValue(/* TODO: */));';
		}

		return implode("\n\n", $propertiesCode);
	}

}
