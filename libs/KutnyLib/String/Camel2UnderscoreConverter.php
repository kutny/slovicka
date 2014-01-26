<?php

namespace KutnyLib\String;

class Camel2UnderscoreConverter {

	public function convert($string) {
		$string = preg_replace_callback('~([A-Z])~', function ($matches) { return '_' . strtolower($matches[1]); }, $string);

		$string = preg_replace('~([0-9]+)~', '_$1', $string);

		if (substr($string, 0, 1) === '_') {
			return substr($string, 1);
		}

		return $string;
	}
}
