<?php

namespace KutnyLib\FileSystem\File;

class ExistenceChecker {

	public function exists($path) {
		return file_exists($path);
	}
}
