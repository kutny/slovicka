<?php

namespace KutnyLib\Translator;

class TranslationList {

	private $translations;

	/**
	 * @param Translation[] $translations
	 */
	public function __construct(array $translations) {
		$this->translations = $translations;
	}

	public function getTranslations() {
		return $this->translations;
	}

	public function getTranslationsByOriginalWord($originalWord) {
		$translations = [];

		foreach ($this->translations as $translation) {
			if ($translation->getOriginalWord() === $originalWord) {
				$translations[] = $translation->getTranslation();
			}
		}

		return $translations;
	}

}
