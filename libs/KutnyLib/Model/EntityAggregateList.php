<?php

namespace KutnyLib\Model;

use KutnyLib\Collection\Imutable\ObjectList;

class EntityAggregateList extends ObjectList {

	/** @deprecated use getValue instead */
	public function getAggregatedValue($entity) {
		return $this->getValue($entity);
	}
}
