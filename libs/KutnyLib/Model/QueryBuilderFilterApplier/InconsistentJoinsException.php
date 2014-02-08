<?php

namespace KutnyLib\Model\QueryBuilderFilterApplier;

use Exception;

class InconsistentJoinsException extends Exception {

	public function __construct($entityClassName, $previousJoinAlias, $currentJoinAlias) {
		parent::__construct(
			'Wrong alias name "' . $currentJoinAlias . '" since entity "' . $entityClassName . '" already has alias "' . $previousJoinAlias . '"'
		);
	}
}
