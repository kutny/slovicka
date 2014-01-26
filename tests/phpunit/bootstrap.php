<?php

use Symfony\Component\DependencyInjection\ContainerInterface;

$kernel = require(__DIR__ . '/../../app/configure.php');
/** @var ContainerInterface $container */
$container = $kernel->getContainer();
