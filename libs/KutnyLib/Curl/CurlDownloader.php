<?php

namespace KutnyLib\Curl;

use KutnyLib\Curl\CurlDownloader\Config;
use KutnyLib\Curl\CurlDownloader\EmptyResponseException;
use KutnyLib\Curl\CurlDownloader\ResponseParser;
use KutnyLib\Curl\CurlDownloader\ResponsesContainer;

class CurlDownloader {

	private $responseParser;

	public function __construct(ResponseParser $responseParser) {
		$this->responseParser = $responseParser;
	}

	public function downloadPage(Config $config) {
		$curlConnection = curl_init($config->getUrl());

		if ($config->getConnectionTimeout()) {
			curl_setopt($curlConnection, CURLOPT_CONNECTTIMEOUT, $config->getConnectionTimeout());
		}

		if ($config->getUserAgent()) {
			curl_setopt($curlConnection, CURLOPT_USERAGENT, $config->getUserAgent());
		}

		curl_setopt($curlConnection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlConnection, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curlConnection, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curlConnection, CURLOPT_VERBOSE, true);
		curl_setopt($curlConnection, CURLOPT_HEADER, true);
		curl_setopt($curlConnection, CURLOPT_VERBOSE, false);

		if ($config->getCookiesStorageFile()) {
			curl_setopt($curlConnection, CURLOPT_COOKIEJAR, $config->getCookiesStorageFile());
			curl_setopt($curlConnection, CURLOPT_COOKIEFILE, $config->getCookiesStorageFile());
		}

		if ($config->getMaxRedirects()) {
			curl_setopt($curlConnection, CURLOPT_MAXREDIRS, $config->getMaxRedirects());
		}

		if ($config->hasHeaders()) {
			curl_setopt($curlConnection, CURLOPT_HTTPHEADER, $this->processHeaders($config->getHeaders()));
		}

		if ($config->getPostData()) {
			curl_setopt($curlConnection, CURLOPT_POST, true);
			curl_setopt($curlConnection, CURLOPT_POSTFIELDS, $config->getPostData()->getRawPostDataString());
		}

		$data = curl_exec($curlConnection);
		curl_close($curlConnection);

		if ($data === false) {
			throw new EmptyResponseException();
		}

		$responses = $this->responseParser->extract($data);

		return new ResponsesContainer($responses);
	}

	private function processHeaders(array $headers) {
		$parsedHeadersArray = array();

		foreach ($headers as $name => $value) {
			$parsedHeadersArray[] = $name . ': ' . $value;
		}

		return $parsedHeadersArray;
	}

}
