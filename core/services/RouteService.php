<?php

namespace Av\Core\Services;

use Av\core\exceptions\RouteException;
use Exception;

/**
 * Class Route
 * @package Av\Core
 */
class RouteService
{

    /**
     * Contains current request.
     *
     * @var \Av\Core\Request
     */
    public $request;
    /**
     * Contains current path.
     *
     * @var string
     */
    public $path;
    /**
     * Array with routes.
     *
     * @var array
     */
    protected $routes = [];
    /**
     * Handler for page 404.
     *
     * @var string
     */
    protected $page404 = '\Av\Core\Controller::page404';
    /**
     * Handler for page 403.
     *
     * @var string
     */
    protected $page403 = '\Av\Core\Controller::page403';

    /**
     * Handler for page 403.
     *
     * @var string
     */
    protected $pageError = '\Av\Core\Controller::pageError';

    /**
     * Route constructor.
     */
    public function __construct()
    {
        $this->routes = require_once('../config/routes.php');
    }

    /**
     * Return defined routes.
     *
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @return \Av\Core\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Handle a request.
     *
     * @param $request
     * @return string
     * @throws Exception
     */
    public function handle($request)
    {
        $this->request = $request;
        $this->path = $request->server['REQUEST_URI'];
        try {
            list($handler, $method) = $this->searchRoute();
            return $this->applyHandler($handler, $method);
        } catch (RouteException $ex) {
            return $this->applyHandler($this->page404);
        } catch (Exception $ex) {
            return $this->applyHandler($this->pageError);
        }

    }

    /**
     * @throws Exception
     */
    protected function searchRoute()
    {
        if (isset($this->routes[$this->path])) {
            $route = $this->routes[$this->path];
            $handler = !empty($route['handler']) ? $route['handler'] : null;
            $method = !empty($route['handler']['method']) ? $route['handler']['method'] : 'GET';
            return [
                $handler,
                $method,
            ];
        } else {
            throw new Exception('Not existing route.', 404);
        }
    }

    /**
     * Tries to fiend handler for such path.
     *
     * @param $handler
     * @param string $method
     * @return mixed
     * @throws Exception
     */
    protected function applyHandler($handler, $method = 'get')
    {
        if (!empty($handler)) {
            if (strtolower($method) == strtolower($this->request->method)) {
                list($class, $method) = explode('::', $handler);
                if (class_exists($class)) {
                    $controller = new $class();
                    if (method_exists($controller, $method)) {
                        return $controller->$method($this->request);
                    } else {
                        throw new RouteException('Not existing controller method.', 404);
                    }
                } else {
                    throw new RouteException('Not existing controller', 404);
                }
            } else {
                throw new RouteException('Wrong method for defined route.', 404);
            }
        } else {
            throw new RouteException('Empty handler in routes.', 404);
        }
    }

}