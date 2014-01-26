<?php

namespace KutnyLib\PhpUnit\CodeGenerator;

class ClassNameToVariableNameConvertor {

	public function convert($className) {
		return strtolower(substr($className, 0, 1)) . substr($className, 1);
	}

}
