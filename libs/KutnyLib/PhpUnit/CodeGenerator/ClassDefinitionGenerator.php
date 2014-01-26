<?php

namespace KutnyLib\PhpUnit\CodeGenerator;

use KutnyLib\PhpUnit\TestCase;
use ReflectionClass;

class ClassDefinitionGenerator {

	private $classBodyGenerator;

	public function __construct(ClassBodyGenerator $classBodyGenerator) {
		$this->classBodyGenerator = $classBodyGenerator;
	}

	public function getCode(ReflectionClass $reflection) {
		$namespace = $this->getNamespace($reflection);

		return
		'<?php' . "\n" .
		($namespace ? "\n" . $namespace . "\n" : '') .
		"\n" .
		$this->getUses() . "\n" .
		"\n" .
		$this->getClassHeader($reflection) . "\n" .
		"\n" .
		$this->classBodyGenerator->getCode($reflection) . "\n" .
		"\n" .
		"}" .
		"\n\n";
	}

	private function getNamespace(ReflectionClass $reflection) {
		if (!$reflection->getNamespaceName()) {
			return null;
		}

		return 'namespace ' . $reflection->getNamespaceName() . ';';
	}

	private function getClassHeader(ReflectionClass $reflection) {
		return 'class ' . $reflection->getShortName() . 'Test extends TestCase {';
	}

	private function getUses() {
		return 'use ' . TestCase::class . ';';
	}

}
