<?php

use Symfony\Component\ClassLoader\ApcClassLoader;
use Tracy\Debugger;

if (!getenv('KUTNY_ENVIRONMENT')) {
	die('Environment variable KUTNY_ENVIRONMENT not set');
}

/* Environment detection */
define('KUTNY_ENVIRONMENT', getenv('KUTNY_ENVIRONMENT'));
$debug = (KUTNY_ENVIRONMENT === 'dev' || KUTNY_ENVIRONMENT === 'test');

/* Some general PHP settings */
mb_internal_encoding('UTF-8');
mb_regex_encoding('UTF-8');
date_default_timezone_set('Europe/Prague');

/* Bootstrap and loader */
$loader = require_once __DIR__.'/../app/bootstrap.php.cache';
if (!$debug && extension_loaded('apc') && ini_get('apc.enabled')) {
	$loader = new ApcClassLoader('slovicka', $loader);
	$loader->register(true);
}

/* Nette debugger initialization */
Debugger::$strictMode = true;

if ($debug) {
	Debugger::enable(Debugger::DEVELOPMENT, __DIR__ . '/logs/', null);
}
else {
	Debugger::enable(Debugger::PRODUCTION, __DIR__ . '/logs/', 'jirkakoutnyn@gmail.com');
}

/* Application kernel booting */
require_once __DIR__.'/../app/AppKernel.php';
$kernel = new AppKernel(KUTNY_ENVIRONMENT, $debug);
$kernel->boot();

/* Kernel return */
return $kernel;
