<?php

namespace Kutny\Practising\Api;

use Kutny\Practising\Answer\Answer;
use Kutny\Practising\Answer\AnswerRepository;
use Kutny\User\User;
use Kutny\Vocabulary\UserVocabulary\UserVocabulary;
use Kutny\Vocabulary\UserVocabulary\UserVocabularyFilter;
use Kutny\Vocabulary\UserVocabulary\UserVocabularyRepository;
use KutnyLib\DateTime\DateTimeFactory;

class PractisingFacade {

	private $answerRepository;
	private $dateTimeFactory;
	private $userVocabularyRepository;
	private $correctAnswersLimit;

	public function __construct(
		AnswerRepository $answerRepository,
		DateTimeFactory $dateTimeFactory,
		UserVocabularyRepository $userVocabularyRepository
	) {
		$this->userVocabularyRepository = $userVocabularyRepository;
		$this->answerRepository = $answerRepository;
		$this->dateTimeFactory = $dateTimeFactory;
		$this->correctAnswersLimit = 4;
	}

	public function getUserVocabulary($userVocabularyId) {
		$filter = new UserVocabularyFilter();
		$filter->setId($userVocabularyId);

		return $this->userVocabularyRepository->fetch($filter);
	}

	public function storeAnswer($answeredCorrectly, UserVocabulary $userVocabulary) {
		$now = $this->dateTimeFactory->getCurrentDateTime();

		$answer = new Answer($answeredCorrectly, $userVocabulary, $now->toDateTime());

		$this->answerRepository->save($answer);

		if ($answeredCorrectly && $userVocabulary->getCorrectAnswers() < $this->correctAnswersLimit) {
			$userVocabulary->setLastCorrectAnswerAt($now->toDateTime());
			$userVocabulary->increaseCorrectAnswers();

			$this->userVocabularyRepository->save($userVocabulary);
		}
		else if (!$answeredCorrectly) {
			$userVocabulary->resetCorrectAnswers();

			$this->userVocabularyRepository->save($userVocabulary);
		}
	}

	public function getVocabulary(User $user) {
		$randomUserVocabularyId = $this->userVocabularyRepository->getRandomUserVocabularyId($user->getId(), $this->correctAnswersLimit);

		$filter = new UserVocabularyFilter();
		$filter->setId($randomUserVocabularyId);

		return $this->userVocabularyRepository->fetch($filter);
	}

}
