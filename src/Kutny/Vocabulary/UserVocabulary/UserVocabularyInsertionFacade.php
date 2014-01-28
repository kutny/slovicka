<?php

namespace Kutny\Vocabulary\UserVocabulary;

use Kutny\User\User;
use Kutny\Vocabulary\Vocabulary;
use Kutny\Vocabulary\VocabularyFilter;
use Kutny\Vocabulary\VocabularyRepository;
use KutnyLib\DateTime\DateTimeFactory;

class UserVocabularyInsertionFacade {

	private $vocabularyRepository;
	private $userVocabularyRepository;
	private $dateTimeFactory;

	public function __construct(
		VocabularyRepository $vocabularyRepository,
		UserVocabularyRepository $userVocabularyRepository,
		DateTimeFactory $dateTimeFactory
	) {
		$this->vocabularyRepository = $vocabularyRepository;
		$this->userVocabularyRepository = $userVocabularyRepository;
		$this->dateTimeFactory = $dateTimeFactory;
	}

	public function insert($englishVocabulary, $userTranslation, $note, User $user) {
		$vocabulary = $this->findVocabulary($englishVocabulary);

		if (!$vocabulary) {
			$vocabulary = $this->createVocabulary($englishVocabulary);

			return $this->createUserVocabulary($vocabulary, $userTranslation, $note, $user);
		}

		$userVocabulary = $this->findUserVocabulary($vocabulary, $user);

		if (!$userVocabulary) {
			$userVocabulary = $this->createUserVocabulary($vocabulary, $userTranslation, $note, $user);
		}

		return $userVocabulary;
	}

	public function getUserVocabulary($id) {
		$filter = new UserVocabularyFilter();
		$filter->setId($id);

		return $this->userVocabularyRepository->fetch($filter);
	}

	public function update(UserVocabulary $userVocabulary) {
		$this->userVocabularyRepository->save($userVocabulary);
	}

	private function findVocabulary($englishVocabulary) {
		$filter = new VocabularyFilter();
		$filter->setEnglishVocabulary($englishVocabulary);

		return $this->vocabularyRepository->fetch($filter);
	}

	private function findUserVocabulary(Vocabulary $vocabulary, User $user) {
		$filter = new UserVocabularyFilter();
		$filter->setVocabularyId($vocabulary->getId());
		$filter->setUserId($user->getId());

		return $this->userVocabularyRepository->fetch($filter);
	}

	private function createVocabulary($englishVocabulary) {
		$vocabulary = new Vocabulary($englishVocabulary);

		$this->vocabularyRepository->save($vocabulary);

		return $vocabulary;
	}

	private function createUserVocabulary(Vocabulary $vocabulary, $userTranslation, $note, User $user) {
		$now = $this->dateTimeFactory->getCurrentDateTime();

		$userVocabulary = new UserVocabulary();
		$userVocabulary->setUser($user);
		$userVocabulary->setVocabulary($vocabulary);
		$userVocabulary->setUserTranslation($userTranslation);
		$userVocabulary->setNote($note);
		$userVocabulary->setCreatedAt($now->toDateTime());

		$this->userVocabularyRepository->save($userVocabulary);

		return $userVocabulary;
	}

}
