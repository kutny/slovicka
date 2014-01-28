<?php

namespace KutnyLib\XmlRpc;

use KutnyLib\Curl\CurlDownloader;
use KutnyLib\Curl\CurlDownloader\Config;
use KutnyLib\Curl\CurlDownloader\RawPostData;

class Client {

	private $responseParser;
	private $requestMessagePreparer;
	private $httpClient;

	public function __construct(IResponseParser $responseParser, RequestMessagePreparer $requestMessagePreparer, CurlDownloader $httpClient) {
		$this->responseParser = $responseParser;
		$this->requestMessagePreparer = $requestMessagePreparer;
		$this->httpClient = $httpClient;
	}

	public function call(Message $message, $endpointUrl) {
		$xmlData = $this->requestMessagePreparer->createXmlData($message);
		$config = $this->createDownloaderConfig($xmlData, $endpointUrl);

		$response = $this->httpClient->downloadPage($config)->getLastResponse();

		return $this->responseParser->parse($response);
	}

	private function createDownloaderConfig($xmlData, $endpointUrl) {
		$postData = new RawPostData($xmlData);

		$config = new Config($endpointUrl);
		$config->setPostData($postData);
		$config->setConnectionTimeout(30);
		$config->setUserAgent('Mozilla/5.0 (Windows NT 6.1; rv:24.0) Gecko/20100101 Firefox/24.0');
		$config->setHeaders(array(
			'Connection' => 'close',
			'Accept-Encoding' => 'gzip, deflate',
			'Accept-Language' => 'cs,en-us;q=0.7,en;q=0.3',
			'Accept-Charset' => 'utf-8,ISO-8859-1;q=0.7,*;q=0.7',
			'Content-Type' => 'text/xml'
		));

		return $config;
	}

}
