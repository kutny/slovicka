<?php

namespace Kutny\Mail\Template;

class FileTemplate {

	const PART_HTML = 'html';
	const PART_TEXT = 'txt';
	const PART_SUBJECT = 'subject';

	private $name;
	private $path;
	private $language;
	private $variables;

	public function __construct($name, $path, $language, array $variables = array()) {
		$this->name = $name;
		$this->path = $path;
		$this->language = $language;
		$this->variables = $variables;
	}

	public function getLanguage() {
		return $this->language;
	}

	public function getName() {
		return $this->name;
	}

	public function getVariables() {
		return $this->variables;
	}

	public function getPath() {
		return $this->path;
	}

	public function getTemplateFilePath($partType) {
		return $this->path . '/' . $this->name . '.' . $partType . '.' . $this->language . '.twig';
	}

}
