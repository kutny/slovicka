<?php

namespace Kutny\Vocabulary\UserVocabulary;

use KutnyLib\Model\EntityList;

class UserVocabularyList extends EntityList {

	public function getIds() {
		return $this->map(function(UserVocabulary $userVocabulary) {
			return $userVocabulary->getId();
		});
	}

}
