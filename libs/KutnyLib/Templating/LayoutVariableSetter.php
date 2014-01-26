<?php

namespace KutnyLib\Templating;

use Exception;

class LayoutVariableSetter {

	public function setIfNotExists(array $variables, $key, $value) {
		if (!array_key_exists($key, $variables)) {
			$variables[$key] = $value;
		}

		return $variables;
	}

	public function setUnchangeable(array $variables, $key, $value) {
		if (array_key_exists($key, $variables)) {
			throw new Exception('Variable ' . $key . ' must NOT be overridden in Controller');
		}

		$variables[$key] = $value;

		return $variables;
	}

}
