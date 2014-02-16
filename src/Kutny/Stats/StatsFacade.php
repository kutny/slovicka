<?php

namespace Kutny\Stats;

use Kutny\User\User;
use Kutny\Vocabulary\UserVocabulary\UserVocabularyRepository;
use KutnyLib\DateTime\Date;

class StatsFacade {

	private $correctAnswersLimit;
	private $userVocabularyRepository;
	private $vocabularyDataPreparer;

	public function __construct(
		$correctAnswersLimit,
		UserVocabularyRepository $userVocabularyRepository,
		VocabularyDataPreparer $vocabularyDataPreparer
	) {
		$this->correctAnswersLimit = $correctAnswersLimit;
		$this->userVocabularyRepository = $userVocabularyRepository;
		$this->vocabularyDataPreparer = $vocabularyDataPreparer;
	}

	public function getAddedVocabularyByDay(User $user, Date $startDate, $dayInterval) {
		$dbData = $this->userVocabularyRepository->getAddedVocabularyStatsByDate($user->getId(), $startDate);

		return $this->vocabularyDataPreparer->getNewKeywordsByDay($dbData, $startDate, $dayInterval);
	}

	public function getAddedVocabularyByDayCumulative(User $user, Date $startDate, $dayInterval) {
		$dbData = $this->userVocabularyRepository->getAddedVocabularyStatsByDate($user->getId(), $startDate);
		$vocabularyCountBeforeDate = $this->userVocabularyRepository->getAddedVocabularySumBeforeDate($user->getId(), $startDate);

		$dbData = $this->vocabularyDataPreparer->getNewKeywordsByDay($dbData, $startDate, $dayInterval);

		$dbData = $this->addCumulativeCount($dbData, $vocabularyCountBeforeDate);

		return $dbData;
	}

	public function getLearnedVocabularyByDay(User $user, Date $startDate, $dayInterval) {
		$dbData = $this->userVocabularyRepository->getLearnedVocabularyStatsByDate($user->getId(), $this->correctAnswersLimit, $startDate);

		return $this->vocabularyDataPreparer->getNewKeywordsByDay($dbData, $startDate, $dayInterval);
	}

	public function getLearnedVocabularyByDayCumulative(User $user, Date $startDate, $dayInterval) {
		$dbData = $this->userVocabularyRepository->getLearnedVocabularyStatsByDate($user->getId(), $this->correctAnswersLimit, $startDate);
		$vocabularyCountBeforeDate = $this->userVocabularyRepository->getLearnedVocabularySumBeforeDate($user->getId(), $this->correctAnswersLimit, $startDate);

		$dbData = $this->vocabularyDataPreparer->getNewKeywordsByDay($dbData, $startDate, $dayInterval);

		$dbData = $this->addCumulativeCount($dbData, $vocabularyCountBeforeDate);

		return $dbData;
	}

	private function addCumulativeCount(array $dbData, $vocabularyCountBeforeDate) {
		foreach ($dbData as $date => $vocabularyCount) {
			if (isset($previousDate)) {
				$dbData[$date] += $dbData[$previousDate];
			}
			else {
				$dbData[$date] += $vocabularyCountBeforeDate;
			}

			$previousDate = $date;
		}

		return $dbData;
	}

}
