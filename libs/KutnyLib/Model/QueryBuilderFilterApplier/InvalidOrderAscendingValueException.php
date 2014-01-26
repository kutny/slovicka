<?php

namespace KutnyLib\Model\QueryBuilderFilterApplier;

class InvalidOrderAscendingValueException extends \Exception {

	public function __construct($itemName, $invalidValue) {
		parent::__construct('Order item ' . $itemName . ' ascending attribute is of type ' . gettype($invalidValue) . ' instead of boolean');
	}
}
