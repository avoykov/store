<?php
/**
 * @file
 * Contains base mapping between routes and handlers.
 */

return [
    '/' => [
        'handler' => '\Av\Controllers\HomeController::home',
        'method' => 'get',
    ],
];