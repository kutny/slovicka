<?php

namespace Kutny\Practising\Api;

use Kutny\User\CurrentUserGetter;
use KutnyLib\Controller\Action\Doorkeeper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PractisingController {

	private $currentUserGetter;
	private $practisingFacade;

	public function __construct(
		CurrentUserGetter $currentUserGetter,
		PractisingFacade $practisingFacade
	) {
		$this->currentUserGetter = $currentUserGetter;
		$this->practisingFacade = $practisingFacade;
	}

	/**
	 * @Route("/v1/practise/get-vocabulary", name="route.api.v1.practise_get_vocabulary")
	 * @Method("GET")
	 */
	public function getVocabulary() {
		return $this->createNextVocabularyResponse();
	}

	/**
	 * @Route("/v1/practise/answer/{userVocabularyId}", name="route.api.v1.practise_answer")
	 * @Doorkeeper(service="vocabulary.user_vocabulary.user_vocabulary_doorkeeper")
	 * @Method("POST")
	 */
	public function answerAction($userVocabularyId, Request $request) {
		$answeredCorrectly = (bool) $request->request->get('answeredCorrectly');

		$answeredUserVocabulary = $this->practisingFacade->getUserVocabulary($userVocabularyId);

		$this->practisingFacade->storeAnswer($answeredCorrectly, $answeredUserVocabulary);

		return $this->createNextVocabularyResponse();
	}

	private function createNextVocabularyResponse() {
		$currentUser = $this->currentUserGetter->getUserEntity();

		$newUserVocabulary = $this->practisingFacade->getVocabulary($currentUser);

		if (!$newUserVocabulary) {
			return new JsonResponse([
				'userVocabularyId' => null
			]);
		}

		return new JsonResponse([
			'userVocabularyId' => $newUserVocabulary->getId(),
			'englishVocabulary' => $newUserVocabulary->getVocabulary()->getEnglishVocabulary(),
			'explanation' => $newUserVocabulary->getExplanation(),
			'userTranslation' => $newUserVocabulary->getUserTranslation(),
			'note' => $newUserVocabulary->getNote()
		]);
	}

}
