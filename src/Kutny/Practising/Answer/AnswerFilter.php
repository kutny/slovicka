<?php

namespace Kutny\Practising\Answer;

use KutnyLib\Model\Filter\Filter;

class AnswerFilter extends Filter {

	public function getEntityClass() {
		return Answer::class;
	}

	public function getAlias() {
		return 'answer';
	}
}
