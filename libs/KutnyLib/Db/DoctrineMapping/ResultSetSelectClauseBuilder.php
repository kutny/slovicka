<?php

namespace KutnyLib\Db\DoctrineMapping;

use KutnyLib\Db\IQuoter;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class ResultSetSelectClauseBuilder {

	private $entityManager;
	private $quoter;

	public function __construct(
		EntityManager $entityManager,
		IQuoter $quoter
	) {
		$this->entityManager = $entityManager;
		$this->quoter = $quoter;
	}

	public function addAliasedClassMapping(ResultSetMappingBuilder $rsm, $class, $tableAlias) {
		$rsm->addRootEntityFromClassMetadata($class, $tableAlias, $this->getColumnAliases($class, $tableAlias));
	}

	public function buildAliasedSelectClause(ResultSetMappingBuilder $rsm) {
		$clauses = [];
		foreach ($rsm->getAliasMap() as $tableAlias => $class) {
			foreach ($this->getColumnAliases($class, $tableAlias) as $columnName => $columnAlias) {
				$clauses[] = $this->quoter->quoteIdentifier($tableAlias) . '.' . $this->quoter->quoteIdentifier($columnName) . ' as ' . $this->quoter->quoteIdentifier($columnAlias);
			}
		}

		return join(', ', $clauses);
	}

	private function getColumnAliases($class, $tableAlias) {
		$columnAliases = [];
		foreach ($this->entityManager->getClassMetadata($class)->getColumnNames() as $columnName) {
			$columnAliases[$columnName] = $tableAlias . '__' . $columnName;
		}

		return $columnAliases;
	}

}
