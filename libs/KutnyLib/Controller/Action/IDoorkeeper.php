<?php

namespace KutnyLib\Controller\Action;

use Symfony\Component\HttpFoundation\Request;

interface IDoorkeeper {

	public function checkAccess(Request $request);

}
