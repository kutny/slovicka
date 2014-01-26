<?php

namespace KutnyLib\Url;

use Exception;

class QuerystringBuilder {

	public function buildQueryString(array $parameters) {
		if (count($parameters) === 0) {
			throw new Exception('No query parameters provided');
		}

		$output = array();

		foreach ($parameters as $name => $value) {
			$output[] = $name . '=' . urlencode($value);
		}

		return implode('&', $output);
	}

}
