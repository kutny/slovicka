<?php

namespace KutnyLib\Templating;

use CG\Proxy\MethodInterceptorInterface;
use CG\Proxy\MethodInvocation;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LayoutFillerInterceptor implements MethodInterceptorInterface {

	private $annotationReader;
	private $container;

	public function __construct(ContainerInterface $container, Reader $annotationReader) {
		$this->annotationReader = $annotationReader;
		$this->container = $container;
	}

	public function intercept(MethodInvocation $invocation) {
		$variables = $invocation->proceed();

		if (!is_array($variables)) {
			return $variables;
		}

		/** @var FillLayout $annotation */
		$annotation = $this->annotationReader->getMethodAnnotation($invocation->reflection, FillLayout::class);

		/** @var ILayoutFiller $layoutFiller */
		$layoutFiller = $this->container->get($annotation->getServiceId());
		return $layoutFiller->setDefaultVariables($variables);
	}

}
