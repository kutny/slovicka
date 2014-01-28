<?php

namespace Kutny\Translator\Api;

use Kutny\User\CurrentUserGetter;
use Kutny\Vocabulary\Normalizer;
use Kutny\Vocabulary\UserVocabulary\UserVocabulary;
use KutnyLib\Translator\Seznam\SlovnikApiTranslator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TranslatorController {

	private $vocabularyNormalizer;
	private $seznamSlovnikApiTranslator;
	private $currentUserGetter;
	private $translatorFacade;

	public function __construct(
		Normalizer $vocabularyNormalizer,
		SlovnikApiTranslator $seznamSlovnikApiTranslator,
		CurrentUserGetter $currentUserGetter,
		TranslatorFacade $translatorFacade
	) {
		$this->vocabularyNormalizer = $vocabularyNormalizer;
		$this->seznamSlovnikApiTranslator = $seznamSlovnikApiTranslator;
		$this->currentUserGetter = $currentUserGetter;
		$this->translatorFacade = $translatorFacade;
	}

	/**
	 * @Route("/v1/translate", name="route.api.v1.translate")
	 * @Method("POST")
	 */
	public function translateAction(Request $request) {
		$englishVocabulary = $this->vocabularyNormalizer->normalize($request->query->get('vocabulary'));

		if (!$englishVocabulary) {
			throw new BadRequestHttpException('Vocabulary not defined');
		}

		$translationList = $this->seznamSlovnikApiTranslator->translate($englishVocabulary, SlovnikApiTranslator::TRANSLATE_EN2CZ);

		$currentUser = $this->currentUserGetter->getUserEntity();

		$userVocabulary = $this->translatorFacade->findVocabulary($englishVocabulary, $currentUser);

		if (!$userVocabulary) {
			$userVocabulary = new UserVocabulary();
		}

		return new JsonResponse([
			'translations' => $translationList->getTranslationsByOriginalWord($englishVocabulary),
			'userVocabularyId' => $userVocabulary->getId(),
			'userTranslation' => $userVocabulary->getUserTranslation(),
			'explanation' => $userVocabulary->getExplanation(),
			'note' => $userVocabulary->getNote()
		]);
	}

}
