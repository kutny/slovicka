<?php

namespace KutnyLib\XmlRpc;

use KutnyLib\Curl\CurlDownloader\Response;

interface IResponseParser {

	public function parse(Response $response);

}
