<?php

namespace KutnyLib\Controller\Action;

use CG\Proxy\MethodInterceptorInterface;
use CG\Proxy\MethodInvocation;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DoorkeeperInterceptor implements MethodInterceptorInterface {

	private $annotationReader;
	private $container;
	private $request;

	public function __construct(ContainerInterface $container, Reader $annotationReader, Request $request) {
		$this->container = $container;
		$this->annotationReader = $annotationReader;
		$this->request = $request;
	}

	public function intercept(MethodInvocation $invocation) {
		/** @var Doorkeeper $annotation */
		$annotation = $this->annotationReader->getMethodAnnotation($invocation->reflection, Doorkeeper::class);

		/** @var IDoorkeeper $doorKeeper */
		$doorKeeper = $this->container->get($annotation->getServiceId());
		$checkResult = $doorKeeper->checkAccess($this->request);

		if ($checkResult === true) {
			return $invocation->proceed();
		}
		else if ($checkResult instanceof Response) {
			return $checkResult;
		}
		else {
			throw new \Exception('Unexpected Doorkeeper check result: ' . var_export($checkResult, true));
		}
	}

}
