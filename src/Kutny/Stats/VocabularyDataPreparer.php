<?php

namespace Kutny\Stats;

use KutnyLib\DateTime\Date;

class VocabularyDataPreparer {

	public function getNewKeywordsByDay(array $dbData, Date $startDate, $dayInterval) {
		$data = [];

		$startDateTimestamp = $startDate->toDateTime()->getTimestamp();

		for ($i = 0; $i < $dayInterval; $i++) {
			$index = date('Y-m-d', $startDateTimestamp + $i * 3600 * 24);

			if (array_key_exists($index, $dbData)) {
				$data[] = (int) $dbData[$index];
			}
			else {
				$data[] = 0;
			}
		}

		return $data;
	}

}
