<?php

namespace KutnyLib\FileSystem\File\ContentGetter;

use RuntimeException;

class UnableToGetContentException extends RuntimeException {

	public function __construct($errorMessage) {
		parent::__construct($errorMessage);
	}

}
