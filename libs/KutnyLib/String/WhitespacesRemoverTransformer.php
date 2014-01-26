<?php

namespace KutnyLib\String;

use Symfony\Component\Form\DataTransformerInterface;

class WhitespacesRemoverTransformer implements DataTransformerInterface {

	private $whitespacesRemover;

	public function __construct(WhitespacesRemover $whitespacesRemover) {
		$this->whitespacesRemover = $whitespacesRemover;
	}

	public function transform($value) {
		return $value;
	}

	public function reverseTransform($value) {
		if ($value === null) {
			return null;
		}

		return $this->whitespacesRemover->removeWhitespaces($value);
	}

}
