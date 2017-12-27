<?php

namespace Av\Core;

use Av\Core\Requests\Request;
use Av\Core\Services\RouteService;

/**
 * Class Kernel core of application.
 * @package Av\Store
 */
class Kernel
{
    /**
     * Contains current request.
     *
     * @var Request
     */
    public static $request;
    /**
     * Contains api key.
     *
     * @var string
     */
    public static $key;
    /**
     * Root directory of application.
     *
     * @var string
     */
    protected static $rootDirectory;
    /**
     * Current path
     *
     * @var string
     */
    protected static $currentPath;
    /**
     * Route service.
     *
     * @var \Av\Core\Services\RouteService
     */
    public $routeService;

    /**
     * Kernel constructor.
     */
    public function __construct()
    {
        $this->routeService = new RouteService();
        $main = require '../config/main.php';
        self::$key = $main['key'];
    }

    /**
     * @return mixed
     */
    public static function getRootDirectory()
    {
        return self::$rootDirectory;
    }

    /**
     * @return string
     */
    public static function getCurrentPath()
    {
        return self::$currentPath;
    }

    /**
     * @return Request
     */
    public static function getRequest()
    {
        return self::$request;
    }

    /**
     * @param Request $request
     */
    public static function setRequest($request)
    {
        self::$request = $request;
    }


    /**
     * Main handler for getting response.
     *
     * @param Request $request
     * @return string
     */
    public function handle($request)
    {
        self::$request = $request;
        self::$rootDirectory = $request->server['DOCUMENT_ROOT'];
        $this->setDocRoot();

        try {
            self::$request->session->start();
            return $this->routeService->handle($request);
        } catch (\Exception $ex) {
            return response()->view('page404');
        }
    }

    /**
     * Helper for setting document root.
     */
    protected function setDocRoot()
    {
        $root = $_SERVER['DOCUMENT_ROOT'];
        $root = str_replace(['public', 'public/'], '', $root);
        if (substr($root, -1) != '/') {
            $root .= '/';
        }

        self::$rootDirectory = $root;

    }


}