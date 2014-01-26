<?php

namespace KutnyLib\Reflection;

use ReflectionMethod;

class MethodCodeExporter {

	public function getMethodCode(ReflectionMethod $method) {
		$filename = $method->getFileName();
		$startLine = $method->getStartLine();
		$endLine = $method->getEndLine();
		$length = $endLine - $startLine;

		$source = file($filename);
		$body = implode("", array_slice($source, $startLine, $length));

		return $body;
	}

}
