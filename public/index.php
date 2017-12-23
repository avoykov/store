<?php

/**
 * @file
 *
 * Pages which starts bootstrap and presents endpoint for application.
 */

use Av\Core\Kernel;
use Av\Core\Requests\Request;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../core/common.php';

$request = Request::getInstance();
$kernel = new Kernel();
$response = $kernel->handle($request);

print $response->render();