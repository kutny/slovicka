<?php

namespace Kutny\Templating;

use Kutny\User\CurrentUserGetter;
use KutnyLib\Templating\ILayoutFiller;
use KutnyLib\Templating\LayoutVariableSetter;

class LayoutFiller implements ILayoutFiller {

	private $layoutVariableSetter;
	private $currentUserGetter;

	public function __construct(
		LayoutVariableSetter $layoutVariableSetter,
		CurrentUserGetter $currentUserGetter
	) {
		$this->layoutVariableSetter = $layoutVariableSetter;
		$this->currentUserGetter = $currentUserGetter;
	}

	/**
	 * @param array $variables
	 * @return array
	 */
	public function setDefaultVariables(array $variables) {
		return $variables;
	}

}