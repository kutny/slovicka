<?php

namespace KutnyLib\Curl\CurlDownloader;

class Response {

	private $body;
	private $status;
	private $headers;

	public function __construct($body, $status, array $headers = array()) {
		$this->body = $body;
		$this->status = $status;
		$this->headers = $headers;
	}

	public function getBody() {
		return $this->body;
	}

	public function getHeaders() {
		return $this->headers;
	}

	public function getStatus() {
		return $this->status;
	}

}
