<?php

namespace KutnyLib\FileSystem\Directory;

use KutnyLib\FileSystem\Directory\DirectoryMaker\UnableToMakeDirectoryException;

class DirectoryMaker {

	public function make($path, $mode = 0777) {
		if (!@mkdir($path, $mode, false)) {
			throw new UnableToMakeDirectoryException($path, $mode);
		}
	}

	public function makeRecursive($path, $mode = 0777) {
		if (!@mkdir($path, $mode, true)) {
			throw new UnableToMakeDirectoryException($path, $mode);
		}
	}

}
