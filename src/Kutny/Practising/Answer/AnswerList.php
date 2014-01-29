<?php

namespace Kutny\Practising\Answer;

use KutnyLib\Model\EntityList;

class AnswerList extends EntityList {

	public function getIds() {
		return $this->map(function(Answer $answer) {
			return $answer->getId();
		});
	}

}
