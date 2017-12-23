<?php

use Av\Core\Connection;
use Av\Core\View;

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
        return Connection::getInstance()->connect();
    } catch (\Exception $ex) {
        return false;
    }
}