<?php

namespace Kutny\Vocabulary\UserVocabulary\Api;

use Kutny\User\CurrentUserGetter;
use Kutny\Vocabulary\Normalizer;
use Kutny\Vocabulary\UserVocabulary\UserVocabularyInsertionFacade;
use KutnyLib\Controller\Action\Doorkeeper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserVocabularyController {

	private $userVocabularyInsertionFacade;
	private $currentUserGetter;
	private $vocabularyNormalizer;

	public function __construct(
		Normalizer $vocabularyNormalizer,
		UserVocabularyInsertionFacade $userVocabularyInsertionFacade,
		CurrentUserGetter $currentUserGetter
	) {
		$this->userVocabularyInsertionFacade = $userVocabularyInsertionFacade;
		$this->currentUserGetter = $currentUserGetter;
		$this->vocabularyNormalizer = $vocabularyNormalizer;
	}

	/**
	 * @Route("/v1/user-vocabulary/{userVocabularyId}", name="route.api.v1.user_vocabulary_get")
	 * @Doorkeeper(service="vocabulary.user_vocabulary.user_vocabulary_doorkeeper")
	 * @Method("GET")
	 */
	public function getAction($userVocabularyId) {
		$userVocabulary = $this->userVocabularyInsertionFacade->getUserVocabulary($userVocabularyId);

		return new JsonResponse([
			'userVocabularyId' => $userVocabularyId,
			'englishVocabulary' => $userVocabulary->getVocabulary()->getEnglishVocabulary(),
			'explanation' => $userVocabulary->getExplanation(),
			'userTranslation' => $userVocabulary->getUserTranslation(),
			'note' => $userVocabulary->getNote()
		]);
	}

	/**
	 * @Route("/v1/user-vocabulary", name="route.api.v1.user_vocabulary_insert")
	 * @Method("POST")
	 */
	public function insertAction(Request $request) {
		if (!$request->request->get('englishVocabulary') || !$request->request->get('userTranslation')) {
			throw new BadRequestHttpException('Missing mandatory attributes englishVocabulary or userTranslation');
		}

		$userVocabulary = $this->userVocabularyInsertionFacade->insert(
			$this->vocabularyNormalizer->normalize($request->request->get('englishVocabulary')),
			$request->request->get('userTranslation'),
			$request->request->get('note'),
			$this->currentUserGetter->getUserEntity()
		);

		return new JsonResponse([
			'done' => true,
			'recordId' => $userVocabulary->getId()
		]);
	}

	/**
	 * @Route("/v1/user-vocabulary/{userVocabularyId}", name="route.api.v1.user_vocabulary_update")
	 * @Doorkeeper(service="vocabulary.user_vocabulary.user_vocabulary_doorkeeper")
	 * @Method("POST")
	 */
	public function updateAction($userVocabularyId, Request $request) {
		$userVocabulary = $this->userVocabularyInsertionFacade->getUserVocabulary($userVocabularyId);

		if ($request->request->get('userTranslation')) {
			$userVocabulary->setUserTranslation($request->request->get('userTranslation'));
		}

		if ($request->request->get('note')) {
			$userVocabulary->setNote($request->request->get('note'));
		}

		$this->userVocabularyInsertionFacade->update($userVocabulary);

		return new JsonResponse([
			'done' => true
		]);
	}

}
