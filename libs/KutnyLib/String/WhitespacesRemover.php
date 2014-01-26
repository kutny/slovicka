<?php

namespace KutnyLib\String;

class WhitespacesRemover {

	public function removeWhitespaces($string) {
		return preg_replace('~[\s]+~', '', $string);
	}

}
