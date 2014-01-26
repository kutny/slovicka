<?php

namespace KutnyLib\Model;

use KutnyLib\Collection\ArrayList;
use KutnyLib\Collection\Pair;

class EntityList extends ArrayList {

	public function indexByIds() {
		return $this->index(function ($entity) {
			return new Pair($entity->getId(), $entity);
		});
	}

}
