<?php

namespace KutnyLib\String;

class DuplicateWhitespacesRemover {

	public function removeDuplicateWhitespaces($string) {
		$string = preg_replace('~[\r\n]~', ' ', $string);
		$string = preg_replace('~[\s]{2,}~', ' ', $string);

		return $string;
	}

}
