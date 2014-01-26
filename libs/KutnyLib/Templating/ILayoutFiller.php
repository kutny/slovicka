<?php

namespace KutnyLib\Templating;

interface ILayoutFiller {

	/**
	 * @param array $variables
	 * @return array
	 */
	public function setDefaultVariables(array $variables);
}
