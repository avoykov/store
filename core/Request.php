<?php

namespace Av\Core;

/**
 * Class Request which contains all info about request.
 * @package Av\Store
 */
class Request
{
    /**
     * Request body parameters based on $_POST.
     *
     * @var array
     */
    public $request;

    /**
     * Query string based on $_GET.
     *
     * @var array
     */
    public $query;

    /**
     * Server array baes on $_SERVER.
     *
     * @var array
     */
    public $server;

    /**
     * Uploaded files based on $_FILES.
     *
     * @var array
     */
    public $files;

    /**
     * Cookies based on global $_COOKIE.
     *
     * @var array
     */
    public $cookies;

    /**
     * Headers based on $_SERVER.
     *
     * @var array
     */
    public $headers;

    /**
     * Indicates request method.
     *
     * @var
     */
    public $method;

    /**
     * Contains original path.
     *
     * @var
     */
    public $path;

    /**
     * Request constructor.
     * @param array $query
     * @param array $request
     * @param array $cookies
     * @param array $files
     * @param array $server
     */
    public function __construct(
        $query = array(),
        $request = array(),
        $cookies = array(),
        $files = array(),
        $server = array()
    ) {
        {
            $this->query = $query;
            $this->request = $request;
            $this->cookies = $cookies;
            $this->files = $files;
            $this->server = $server;

            $this->method = strtolower($_SERVER['REQUEST_METHOD']);
            $this->path = $_SERVER['REQUEST_URI'];
        }
    }

    /**
     * Creates Request based on PHP globals.
     *
     * @return Request
     */
    public static function getInstance()
    {
        return new Request($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
    }
}