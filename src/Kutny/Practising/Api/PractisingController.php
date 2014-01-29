<?php

namespace Kutny\Practising\Api;

use Kutny\User\CurrentUserGetter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

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
	 * @Route("/v1/practise/get-vocabulary", name="route.api.v1.practise_next_vocabulary")
	 * @Method("GET")
	 */
	public function getNextVocabularyAction() {
		$currentUser = $this->currentUserGetter->getUserEntity();
		$userVocabulary = $this->practisingFacade->getVocabulary($currentUser);

		return new JsonResponse([
			'userVocabularyId' => $userVocabulary->getId(),
			'englishVocabulary' => $userVocabulary->getVocabulary()->getEnglishVocabulary(),
			'explanation' => $userVocabulary->getExplanation(),
			'userTranslation' => $userVocabulary->getUserTranslation(),
			'note' => $userVocabulary->getNote()
		]);
	}

}
