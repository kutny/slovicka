<?php

namespace Kutny\Practising\Api;

use Kutny\User\User;
use Kutny\Vocabulary\UserVocabulary\UserVocabularyFilter;
use Kutny\Vocabulary\UserVocabulary\UserVocabularyRepository;

class PractisingFacade {

	private $userVocabularyRepository;

	public function __construct(
		UserVocabularyRepository $userVocabularyRepository
	) {
		$this->userVocabularyRepository = $userVocabularyRepository;
	}

	public function getVocabulary(User $user) {
		$randomUserVocabularyId = $this->userVocabularyRepository->getRandomUserVocabularyId($user->getId());

		$filter = new UserVocabularyFilter();
		$filter->setId($randomUserVocabularyId);

		return $this->userVocabularyRepository->fetch($filter);
	}

}
