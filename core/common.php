<?php

use Av\Core\View;

/**
 * Helper for creating view object
 *
 * @param $name
 * @param array $params
 * @return mixed
 */
function view($name, $params = [])
{

    return new View($name, $params);
}