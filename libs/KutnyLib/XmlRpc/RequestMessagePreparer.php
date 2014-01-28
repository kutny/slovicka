<?php

namespace KutnyLib\XmlRpc;

use KutnyLib\Curl\CurlDownloader;

class RequestMessagePreparer {

	public function createXmlData(Message $message) {
		$xmlData = '<?xml version="1.0" encoding="utf-8"?>';

		$xmlData .= '<methodCall>';
		$xmlData .= '<methodName>' . $message->getMethod() . '</methodName>';
		$xmlData .= '<params>';

		foreach ($message->getParameters() as $parameter) {
			$xmlData .= '<param><value>' . $parameter->getXmlFormatedValue() . '</value></param>';
		}

		$xmlData .= '</params>';
		$xmlData .= '</methodCall>';

		return $xmlData;
	}

}
