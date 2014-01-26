<?php

namespace KutnyLib\PhpUnit;

use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use ReflectionClass;
use RuntimeException;

class TestCase extends PHPUnit_Framework_TestCase {

	protected function setUp() {
		parent::setUp();
	}

	protected function assertMethodAnnotation($annotation, $className, $methodName) {
		$classReflection = new ReflectionClass($className);
		$methodReflection = $classReflection->getMethod($methodName);
		$methodDocComment = $methodReflection->getDocComment();

		preg_match('~\*\s+@(' . preg_quote($annotation) . ')\s+\*~', $methodDocComment, $m); /* Very naive implementation */

		$this->assertTrue(
			array_key_exists(1, $m) && $m[1] === $annotation,
			'Method ' . $className . '::' . $methodName . ' has ' . '@' . $annotation . ' annotation'
		);
	}

	/** @return PHPUnit_Framework_MockObject_MockObject */
	protected function createMock($interfaceName) {
		if (!class_exists($interfaceName) && !interface_exists($interfaceName)) {
			throw new RuntimeException('Class or interface \'' . $interfaceName . '\' does not exist');
		}

		$mockBuilder = $this->getMockBuilder($interfaceName);
		if (!(new ReflectionClass($interfaceName))->isInterface()) {
			$mockBuilder->disableOriginalConstructor();
		}
		return $mockBuilder->getMock();
	}

	protected function getService($id) {
		global $container;
		return $container->get($id);
	}

	protected function getParameter($parameter) {
		global $container;
		return $container->getParameter($parameter);
	}

	protected function assertTransactionalMethod($className, $methodName) {
		$this->assertMethodAnnotation('Transactional()', $className, $methodName);
	}
}
