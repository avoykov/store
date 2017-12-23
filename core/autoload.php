<?php
/**
 * @file
 * Simple autoloader.
 */

/**
 * Handle trying to add not existing class
 *
 * @param string $className
 */
function __autoload($className)
{
    $folders = [
        'core',
        'models',
        'controllers',
        'views',
    ];

    $root = $_SERVER['DOCUMENT_ROOT'];
    $root = str_replace(['public', 'public/'], '', $root);
    if (substr($root, -1) != '/') {
        $root .= '/';
    }
    $parts = explode('\\', $className);
    $name = end($parts);

    foreach ($folders as $folder) {
        $fullPath = "{$root}{$folder}/{$name}.php";
        if (file_exists($fullPath)) {
            require_once($fullPath);
            return;
        }
    }
}