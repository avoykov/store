<?php

namespace Av\Core;

/**
 * Class Kernel core of application.
 * @package Av\Store
 */
class Kernel
{
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
     * Contains current request.
     *
     * @var \Av\Core\Request
     */
    public $request;
    /**
     * Route service.
     *
     * @var \Av\Core\Route
     */
    public $routeService;

    /**
     * Kernel constructor.
     */
    public function __construct()
    {
        $this->routeService = new Route();
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
     * @return \Av\Core\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Main handler for getting response.
     *
     * @param \Av\Core\Request $request
     * @return string
     */
    public function handle($request)
    {
        $this->request = $request;
        self::$rootDirectory = $request->server['DOCUMENT_ROOT'];
        $this->setDocRoot();

        try {
            return $this->routeService->handle($request);
        } catch (\Exception $ex) {
            return $ex->getMessage();
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