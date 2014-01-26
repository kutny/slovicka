<?php

namespace KutnyLib\Templating;

use Doctrine\Common\Annotations\Reader;
use JMS\AopBundle\Aop\PointcutInterface;
use ReflectionClass;
use ReflectionMethod;

class LayoutFillerPointcut implements PointcutInterface {

	private $annotationReader;

	public function __construct(Reader $annotationReader) {
		$this->annotationReader = $annotationReader;
	}

	public function matchesClass(ReflectionClass $class) {
		return preg_match('~Controller$~', $class->getName());
	}

	public function matchesMethod(ReflectionMethod $method) {
		return $method->isPublic() && $this->annotationReader->getMethodAnnotation($method, FillLayout::class) !== null;
	}

}
