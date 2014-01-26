<?php

namespace KutnyLib\Model;

use KutnyLib\Model\Filter\OrderItem;
use KutnyLib\Model\QueryBuilderFilter\Join;
use KutnyLib\Model\QueryBuilderFilter\LeftJoin;
use KutnyLib\Model\QueryBuilderFilter\LeftJoinWith;
use KutnyLib\Model\QueryBuilderFilter\JoinWith;
use KutnyLib\Model\QueryBuilderFilterApplier\InconsistentJoinsException;
use KutnyLib\Model\QueryBuilderFilterApplier\InvalidOrderAscendingValueException;
use KutnyLib\Model\QueryBuilderFilterApplier\InvalidOrderException;
use Doctrine\ORM\QueryBuilder;

class QueryBuilderFilterApplier implements IQueryBuilderFilterApplier {

	public function apply(QueryBuilderFilter $filter, QueryBuilder $queryBuilder) {
		$this->applySelect($filter, $queryBuilder);
		$this->applyFrom($filter, $queryBuilder);
		$this->applyJoins($filter, $queryBuilder);
		$this->applyConditions($filter, $queryBuilder);
		$this->applyParameters($filter, $queryBuilder);
		$this->applyOrder($filter->getOrderItems(), $queryBuilder);
		$this->applyLimit($filter, $queryBuilder);
		$this->applyOffset($filter, $queryBuilder);
		$this->applyGroupBy($filter, $queryBuilder);
	}

	private function applySelect(QueryBuilderFilter $filter, QueryBuilder $queryBuilder) {
		if ($filter->getSelect()) {
			$queryBuilder->select($filter->getSelect());
		}
	}

	private function applyFrom(QueryBuilderFilter $filter, QueryBuilder $queryBuilder) {
		$queryBuilder->from(
			$filter->getFromEntity(),
			$filter->getFromAlias()
		);
	}

	private function applyJoins(QueryBuilderFilter $filter, QueryBuilder $queryBuilder) {
		/** @var Join[] $previousJoins */
		$previousJoins = array();

		foreach ($filter->getJoins() as $join) {
			$joinEntity = $join->getEntityClassName();
			$joinAlias = $join->getAlias();

			if (!array_key_exists($joinEntity, $previousJoins)) {
				$previousJoins[$joinEntity] = $join;

				switch (get_class($join)) {

					case LeftJoinWith::class:
						/** @var LeftJoinWith $join */
						$queryBuilder->leftJoin($joinEntity, $joinAlias, \Doctrine\ORM\Query\Expr\Join::WITH, $join->getWithCondition());
						break;

					case LeftJoin::class:
						$queryBuilder->leftJoin($joinEntity, $joinAlias);
						break;

					case JoinWith::class:
						/** @var JoinWith $join */
						$queryBuilder->join($joinEntity, $joinAlias, \Doctrine\ORM\Query\Expr\Join::WITH, $join->getWithCondition());
						break;

					case Join::class:
						$queryBuilder->join($joinEntity, $joinAlias);
						break;

					default:
						throw new \Exception('Invalid JOIN type: ' . get_class($join));

				}
			}
			else if ($previousJoins[$joinEntity]->getAlias() !== $joinAlias) {
				throw new InconsistentJoinsException($joinEntity, $previousJoins[$joinEntity]->getAlias(), $joinAlias);
			}
		}
	}

	private function applyConditions(QueryBuilderFilter $filter, QueryBuilder $queryBuilder) {
		foreach ($filter->getConditions() as $condition) {
			$queryBuilder->andWhere($condition);
		}
	}

	private function applyParameters(QueryBuilderFilter $filter, QueryBuilder $queryBuilder) {
		foreach ($filter->getParameters() as $parameterName => $parameterValue) {
			$queryBuilder->setParameter($parameterName, $parameterValue);
		}
	}

	/**
	 * @SuppressWarnings(PMD.ExcessiveMethodLength)
	 * @SuppressWarnings(PMD.NPathComplexity)
	 */
	private function applyOrder(array $orderItems, QueryBuilder $queryBuilder) {
		$orderedItems = array();
		foreach ($orderItems as $orderItem) {
			/** @var OrderItem $orderItem */
			$orderItemPosition = $orderItem->getPosition();
			if (array_key_exists($orderItemPosition, $orderedItems)) {
				throw new InvalidOrderException($orderItemPosition);
			}
			$orderedItems[$orderItemPosition] = $orderItem;
		}

		ksort($orderedItems);

		foreach ($orderedItems as $orderItem) {
			/** @var \KutnyLib\Model\QueryBuilderFilter\OrderItem $orderItem */
			$itemAscendingValue = $orderItem->isAscending();
			$itemAttributeName = $orderItem->getAttributeName();
			if (!is_bool($itemAscendingValue)) {
				throw new InvalidOrderAscendingValueException($itemAttributeName, $itemAscendingValue);
			}

			$queryBuilder->addOrderBy($itemAttributeName, $itemAscendingValue ? 'ASC' : 'DESC');
		}
	}

	private function applyLimit(QueryBuilderFilter $filter, QueryBuilder $queryBuilder) {
		$queryBuilder->setMaxResults($filter->getLimit());
	}

	private function applyOffset(QueryBuilderFilter $filter, QueryBuilder $queryBuilder) {
		$queryBuilder->setFirstResult($filter->getOffset());
	}

	private function applyGroupBy(QueryBuilderFilter $filter, QueryBuilder $queryBuilder) {
		if ($filter->getGroupBy()) {
			$queryBuilder->groupBy($filter->getGroupBy());
		}
	}
}
