<?php

namespace Kutny\Vocabulary\UserVocabulary;

use Kutny\User\CurrentUserGetter;
use KutnyLib\Controller\Action\IDoorkeeper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserVocabularyDoorkeeper implements IDoorkeeper {

	private $currentUserGetter;
	private $userVocabularyRepository;

	public function __construct(CurrentUserGetter $currentUserGetter, UserVocabularyRepository $userVocabularyRepository) {
		$this->currentUserGetter = $currentUserGetter;
		$this->userVocabularyRepository = $userVocabularyRepository;
	}

	public function checkAccess(Request $request) {
		$userVocabularyId = $request->get('userVocabularyId');

		$userVocabulary = $this->getUserVocabulary($userVocabularyId);

		if (!$userVocabulary) {
			throw new NotFoundHttpException('User vocabulary with ID: ' . $userVocabularyId . ' does not exist');
		}

		$currentUser = $this->currentUserGetter->getUserEntity();

		if ($userVocabulary->getUser()->getId() !== $currentUser->getId()) {
			throw new AccessDeniedException('User ' . $currentUser->getId() . ' is NOT allowed to access user vocabulary with ID: ' . $userVocabulary->getId());
		}

		return true;
	}

	private function getUserVocabulary($userVocabularyId) {
		$filter = new UserVocabularyFilter();
		$filter->setId($userVocabularyId);

		return $this->userVocabularyRepository->fetch($filter);
	}

}
