<?php

namespace Kutny\Vocabulary;

use KutnyLib\Model\Filter\Filter;
use KutnyLib\Model\QueryBuilderFilter\Condition;
use KutnyLib\Model\QueryBuilderFilter\Parameter;

class VocabularyFilter extends Filter {

	public function setId($id) {
		$parameter = new Parameter('vocabularyId', $id);
		$condition = new Condition('vocabulary.id = :vocabularyId', [$parameter]);

		$this->add($condition);
	}

	public function setEnglishVocabulary($englishVocabulary) {
		$parameter = new Parameter('englishVocabulary', $englishVocabulary);
		$condition = new Condition('vocabulary.englishVocabulary = :englishVocabulary', [$parameter]);

		$this->add($condition);
	}

	public function getEntityClass() {
		return Vocabulary::class;
	}

	public function getAlias() {
		return 'vocabulary';
	}

}
