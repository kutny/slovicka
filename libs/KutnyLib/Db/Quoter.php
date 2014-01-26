<?php

namespace KutnyLib\Db;

use Doctrine\ORM\EntityManager;

class Quoter implements IQuoter {

	private $entityManager;

	public function __construct(EntityManager $entityManager) {
		$this->entityManager = $entityManager;
	}

	/**
	 * @param string $value to be escaped
	 * @return string
	 */
	public function quote($value) {
		return $this->entityManager->getConnection()->quote($value);
	}

	/**
	 * @param string $identifier to be escaped
	 * @return string
	 */
	public function quoteIdentifier($identifier) {
		return $this->entityManager->getConnection()->quoteIdentifier($identifier);
	}
}
