<?php

namespace Kutny\Translator\Api;

use Kutny\User\User;
use Kutny\Vocabulary\UserVocabulary\UserVocabularyFilter;
use Kutny\Vocabulary\UserVocabulary\UserVocabularyRepository;

class TranslatorFacade {

	private $userVocabularyRepository;

	public function __construct(
		UserVocabularyRepository $userVocabularyRepository
	) {
		$this->userVocabularyRepository = $userVocabularyRepository;
	}

	public function findVocabulary($englishVocabulary, User $user) {
		$filter = new UserVocabularyFilter();
		$filter->setEnglishVocabulary($englishVocabulary);
		$filter->setUserId($user->getId());

		return $this->userVocabularyRepository->fetch($filter);
	}

}
