<?php

namespace KutnyLib\PhpUnit;

class MethodParser {

	/**
	 * NOTE: only the first method call is processed by now
	 */
	public function findPropertyMethodInCode($propertyName, $methodPhpCode) {
		$tokenizedCode = token_get_all('<?php' . $methodPhpCode);

		for ($i = 0; $i < count($tokenizedCode); $i++) {
			if (isset($tokenizedCode[$i][1]) && $tokenizedCode[$i][1] === $propertyName) {
				$methodName = $tokenizedCode[$i + 2][1];

				$methodArguments = $this->processMethodToken(array_slice($tokenizedCode, $i + 3));

				break;
			}
		}

		if (!isset($methodName, $methodArguments)) {
			throw new UnableToParseMethodCallException();
		}

		return new ParsedMethod($methodName, $methodArguments);
	}

	public function propertyMethodCallExistsInPhpCode($propertyName, $methodPhpCode) {
		return (bool) preg_match('~\$this->' . preg_quote($propertyName, '~') . '->[^(]+~', $methodPhpCode);
	}

	/**
	 * @SuppressWarnings(PMD.ExcessiveMethodLength)
	 */
	private function processMethodToken(array $tokenizedCode) {
		$arguments = array();

		$start = 1; // ignore the first "(" character

		$argument = '';

		for ($i = $start; $i < count($tokenizedCode); $i++) {
			// method argument is function call
			if ($tokenizedCode[$i] === '(') {
				$argument .= '()';

				$i = $i + 2;
			}

			// method end bracket -> end the loop
			if ($tokenizedCode[$i] === ')') {
				$arguments[] = trim($argument);

				break;
			}

			if ($tokenizedCode[$i] === ',') {
				$arguments[] = trim($argument);
				$argument = '';

				continue;
			}

			if (isset($tokenizedCode[$i][1])) {
				$argument .= $tokenizedCode[$i][1];
			}
			else {
				$argument .= $tokenizedCode[$i];
			}
		}

		return $arguments;
	}

}
