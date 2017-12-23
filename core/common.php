<?php

use Av\Core\Database\Connection;
use Av\Core\Database\PdoDecorator;
use Av\Core\Views\View;

/**
 * Helper for creating view object
 *
 * @param $name
 * @param array $params
 * @return mixed
 */
function View($name, $params = [])
{
    return new View($name, $params);
}

/**
 * Helper for working with DB.
 */
function DB()
{
    try {
        return new PdoDecorator(Connection::getInstance()->connect());
    } catch (\Exception $ex) {
        return false;
    }
}

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