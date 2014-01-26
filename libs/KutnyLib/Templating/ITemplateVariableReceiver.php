<?php

namespace KutnyLib\Templating;

interface ITemplateVariableReceiver {

	/**
	 * @param string $name
	 * @param mixed $value
	 */
	function __set($name, $value);

	/**
	 * @param string $name
	 */
	function __unset($name);
}
