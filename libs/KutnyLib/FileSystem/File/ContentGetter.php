<?php

namespace KutnyLib\FileSystem\File;

use KutnyLib\FileSystem\File\ContentGetter\UnableToGetContentException;

class ContentGetter {

	public function getContent($path) {
		$content = @file_get_contents($path);
		if ($content === false) {
			$error = error_get_last();
			$errorMessage = $error['message'];
			throw new UnableToGetContentException($errorMessage);
		}
		return $content;
	}

}
