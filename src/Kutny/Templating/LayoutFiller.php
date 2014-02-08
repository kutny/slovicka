<?php

namespace Kutny\Templating;

use Kutny\User\CurrentUserGetter;
use KutnyLib\Templating\ILayoutFiller;
use KutnyLib\Templating\LayoutVariableSetter;

class LayoutFiller implements ILayoutFiller {

	private $apiHostname;
	private $layoutVariableSetter;
	private $currentUserGetter;

	public function __construct(
		$apiHostname,
		LayoutVariableSetter $layoutVariableSetter,
		CurrentUserGetter $currentUserGetter
	) {
		$this->apiHostname = $apiHostname;
		$this->layoutVariableSetter = $layoutVariableSetter;
		$this->currentUserGetter = $currentUserGetter;
	}

	/**
	 * @param array $variables
	 * @return array
	 */
	public function setDefaultVariables(array $variables) {
		$variables = $this->layoutVariableSetter->setUnchangeable($variables, 'apiHostname', $this->apiHostname);

		return $variables;
	}

}
