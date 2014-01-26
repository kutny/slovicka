<?php

namespace KutnyLib\Controller\Action;

/**
 * @Annotation
 */
class Doorkeeper {

	private $serviceId;

	public function __construct($options) {
		$this->serviceId = $options['service'];
	}

	public function getServiceId() {
		return $this->serviceId;
	}

}
