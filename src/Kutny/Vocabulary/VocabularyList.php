<?php

namespace Kutny\Vocabulary;

use KutnyLib\Model\EntityList;

class VocabularyList extends EntityList {

	public function getIds() {
		return $this->map(function(Vocabulary $vocabulary) {
			return $vocabulary->getId();
		});
	}

}
