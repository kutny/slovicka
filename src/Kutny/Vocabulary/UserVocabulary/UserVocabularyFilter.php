<?php

namespace Kutny\Vocabulary\UserVocabulary;

use Kutny\Vocabulary\Vocabulary;
use KutnyLib\Model\Filter\Filter;
use KutnyLib\Model\QueryBuilderFilter\Condition;
use KutnyLib\Model\QueryBuilderFilter\JoinWith;
use KutnyLib\Model\QueryBuilderFilter\Parameter;

class UserVocabularyFilter extends Filter {

	public function setId($id) {
		$parameter = new Parameter('id', $id);
		$condition = new Condition('userVocabulary.id = :id', [$parameter]);

		$this->add($condition);
	}

	public function setVocabularyId($vocabularyId) {
		$parameter = new Parameter('vocabularyId', $vocabularyId);
		$condition = new Condition('userVocabulary.vocabulary = :vocabularyId', [$parameter]);

		$this->add($condition);
	}

	public function setUserId($userId) {
		$parameter = new Parameter('userId', $userId);
		$condition = new Condition('userVocabulary.user = :userId', [$parameter]);

		$this->add($condition);
	}

	public function setEnglishVocabulary($englishVocabulary) {
		$join = new JoinWith(Vocabulary::class, 'vocabulary', 'vocabulary.id = userVocabulary.vocabulary');
		$parameter = new Parameter('englishVocabulary', $englishVocabulary);
		$condition = new Condition('vocabulary.englishVocabulary = :englishVocabulary', [$parameter]);

		$this->addJoin($join);
		$this->add($condition);
	}

	public function getEntityClass() {
		return UserVocabulary::class;
	}

	public function getAlias() {
		return 'userVocabulary';
	}
}
