<?php

namespace KutnyLib\Translator\Seznam;

use KutnyLib\Translator\TranslationList;
use KutnyLib\XmlRpc\Client;
use KutnyLib\XmlRpc\Message;
use KutnyLib\XmlRpc\Parameter\IntegerParameter;
use KutnyLib\XmlRpc\Parameter\StringParameter;

class SlovnikApiTranslator {

	const TRANSLATE_EN2CZ = 'en_cz';

	private $xmlRpcClient;
	private $appId;
	private $apiEndpointUrl;

	public function __construct(Client $xmlRpcClient) {
		$this->xmlRpcClient = $xmlRpcClient;
		$this->appId = '0501000000F518924AF59C11E0B3AE0018511AB9AFAB7E9802';
		$this->apiEndpointUrl = 'http://api.slovnik.seznam.cz/RPC2';
	}

	/**
	 * @return TranslationList
	 */
	public function translate($word, $translationDirection, $limit = 10, $offset = 0) {
		$xmlRpcParams = [
			new StringParameter($word),
			new StringParameter($translationDirection),
			new IntegerParameter($offset),
			new IntegerParameter($limit),
			new StringParameter($this->appId),
		];

		$xmlRpcMessage = new Message('toolbar.search', $xmlRpcParams);

		return $this->xmlRpcClient->call($xmlRpcMessage, $this->apiEndpointUrl);
	}

}
