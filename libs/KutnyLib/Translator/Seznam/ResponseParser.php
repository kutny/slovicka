<?php

namespace KutnyLib\Translator\Seznam;

use KutnyLib\Curl\CurlDownloader\Response;
use KutnyLib\Translator\Translation;
use KutnyLib\Translator\TranslationList;
use KutnyLib\XmlRpc\IResponseParser;

class ResponseParser implements IResponseParser {

	public function parse(Response $response) {
		$translations = [];

		$xml = simplexml_load_string($response->getBody());

		$status = (int)$xml->params->param->value->struct->member->value->i4;

		if ($status !== 200) {
			throw new \Exception('Status: ' . $status);
		}

		$members = $xml->params->param->value->struct->member[2]->value->array->data->value;

		foreach ($members as $member) {
			$originalWord = (string) $member->struct->member[0]->value->string;
			$translation = (string) $member->struct->member[1]->value->string;

			$translations[] = new Translation($originalWord, $translation);
		}

		return new TranslationList($translations);
	}

}
