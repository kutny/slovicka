<?php

namespace KutnyLib\Db;

use CG\Proxy\MethodInterceptorInterface;
use CG\Proxy\MethodInvocation;
use Doctrine\ORM\EntityManager;
use Exception;

class TransactionalInterceptor implements MethodInterceptorInterface {

	private $em;

	public function __construct(EntityManager $em) {
		$this->em = $em;
	}

	public function intercept(MethodInvocation $invocation) {
		$connection = $this->em->getConnection();
		$connection->beginTransaction();
		try {
			$result = $invocation->proceed();
			$connection->commit();

			return $result;
		}
		catch (Exception $ex) {
			$connection->rollBack();

			throw $ex;
		}
	}
}
