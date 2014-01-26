<?php

namespace KutnyLib\Db;

use Doctrine\Common\Annotations\Reader;
use JMS\AopBundle\Aop\PointcutInterface;
use ReflectionClass;
use ReflectionMethod;

class TransactionalPointcut implements PointcutInterface {

	private $reader;

	public function __construct(Reader $reader) {
		$this->reader = $reader;
	}

	/**
	 * @inheritdoc
	 */
	public function matchesClass(ReflectionClass $class) {
		return true;
	}

	public function matchesMethod(ReflectionMethod $method) {
		return null !== $this->reader->getMethodAnnotation($method, Transactional::class);
	}
}
