<?php

namespace KutnyLib\Translator;

class Translation {

	private $originalWord;
	private $translation;

	public function __construct($originalWord, $translation) {
		$this->originalWord = $originalWord;
		$this->translation = $translation;
	}

	public function getOriginalWord() {
		return $this->originalWord;
	}

	public function getTranslation() {
		return $this->translation;
	}

}
