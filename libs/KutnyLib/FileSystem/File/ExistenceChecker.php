<?php

namespace KutnyLib\FileSystem\File;

class FileExistenceChecker {

	public function exists($path) {
		return file_exists($path);
	}
}
