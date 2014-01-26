<?php

namespace KutnyLib\Model\QueryBuilderFilterApplier;

class InvalidOrderException extends \Exception {

	public function __construct($position) {
		parent::__construct('Multiple order items at position ' . $position);
	}
}
