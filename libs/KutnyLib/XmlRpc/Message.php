<?php

namespace KutnyLib\XmlRpc;

use KutnyLib\XmlRpc\Parameter\GeneralParameter;

class Message {

	private $method;
	private $parameters;

	/**
	 * @param string $method
	 * @param GeneralParameter[] $parameters
	 */
	public function __construct($method, array $parameters) {
		$this->method = $method;
		$this->parameters = $parameters;
	}

	public function getMethod() {
		return $this->method;
	}

	public function getParameters() {
		return $this->parameters;
	}

}
