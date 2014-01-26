<?php

namespace KutnyLib\Templating;

/**
 * @Annotation
 */
class FillLayout {

	private $serviceId;

	public function __construct($options) {
		$this->serviceId = $options['service'];
	}

	public function getServiceId() {
		return $this->serviceId;
	}

}
