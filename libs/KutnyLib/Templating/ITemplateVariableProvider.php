<?php

namespace KutnyLib\Templating;

interface ITemplateVariableProvider {

	/**
	 * @param string $name
	 * @return mixed
	 */
	function __get($name);

	/**
	 * @param string $name
	 * @return bool
	 */
	function __isset($name);
}
