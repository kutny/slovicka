<?php

namespace KutnyLib\FileSystem\Directory\DirectoryMaker;

use Exception;

class UnableToMakeDirectoryException extends Exception {

	public function __construct($path, $mode) {
		parent::__construct('Unable to make directory \'' . $path . '\' with mode 0' . decoct($mode));
	}

}
