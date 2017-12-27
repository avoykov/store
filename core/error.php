<?php
/**
 * @file
 *
 * Contains logic related error handling.
 */

$config = require_once '../config/main.php';
if (empty($config['debug'])) {
    /**
     * Handler for errors
     *
     * @param null $number
     * @param null $message
     * @return string
     *
     * @todo will be nice to add some logs and move it separate class.
     */
    function storeErrorHandler($number = null, $message = null)
    {
        $view = new View('pageError');
        return $view->render();
    }

    set_error_handler('storeErrorHandler');
    register_shutdown_function('storeErrorHandler');

    error_reporting(0);
}