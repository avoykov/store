<?php

/**
 * @file
 *
 * Pages which starts bootstrap and presents endpoint for application.
 */

use Av\Core\Kernel;
use Av\Core\Request;

require_once '../core/autoload.php';
require_once '../core/common.php';

$request = Request::getInstance();
$kernel = new Kernel();
$response = $kernel->handle($request);

print $response->render();