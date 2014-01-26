<?php

namespace KutnyLib\Db;

class WhereConditionBuilder {

	private $quoter;

	public function __construct(IQuoter $quoter) {
		$this->quoter = $quoter;
	}

	public function build(array $filters) {
		$wherePart = array();
		if (count($filters)) {
			foreach ($filters as $columnName => $filterValue) {
				if (preg_match('~^([<>=])(.+)$~', $filterValue, $matches)) {
					$wherePart[] = $this->quoter->quoteIdentifier($columnName) . ' ' . $matches[1] . ' ' . $this->quoter->quote($matches[2]);
				}
				else {
					$wherePart[] = $this->quoter->quoteIdentifier($columnName) . ' LIKE ' . $this->quoter->quote('%' . $filterValue . '%');
				}
			}
		}
		$where = implode(' AND ', $wherePart);
		return $where;
	}

}
