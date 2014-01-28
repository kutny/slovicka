<?php

namespace Kutny\Vocabulary;

use KutnyLib\String\DuplicateWhitespacesRemover;

class Normalizer {

	private $duplicateWhitespacesRemover;

	public function __construct(DuplicateWhitespacesRemover $duplicateWhitespacesRemover) {
		$this->duplicateWhitespacesRemover = $duplicateWhitespacesRemover;
	}

	public function normalize($vocabulary) {
		$vocabulary = trim(mb_strtolower($vocabulary));
		$vocabulary = preg_replace('~[\s]~', ' ', $vocabulary);
		$vocabulary = $this->duplicateWhitespacesRemover->removeDuplicateWhitespaces($vocabulary);

		return $vocabulary;
	}

}
