<?php

namespace Av\Core\Services;

use Av\Core\Exceptions\RouteException;
use Av\Core\Requests\Request;
use Av\Core\Responses\Response;
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
     * @var Request
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
     * Pattern for checking routes.
     *
     * @var string
     */
    protected $pattern;
    /**
     * Contains route data.
     *
     * @var array
     */
    protected $routeData = [];
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
        $routes = require_once('../config/routes.php');
        $i = 0;
        foreach ($routes as $route => $value) {
            $name = 'route' . $i++;
            $this->routes[$name] = $value;
            $this->routes[$name]['route'] = $route;
        }
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
     * @return Request
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
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function handle($request)
    {
        $this->request = $request;
        if (!$request->validateCsrf()) {
            $response = new Response('Potential CSRF attack', 404);
            return $response;
        }
        $this->path = $request->path == '/' ? '/home' : $request->path;
        $this->path = filter_var($this->path, FILTER_SANITIZE_SPECIAL_CHARS);
        try {
            list($handler, $method, $params) = $this->searchRoute();
            return $this->applyHandler($handler, $method, $params);
        } catch (RouteException $ex) {
            return response()->view('page404');
        } catch (Exception $ex) {
            return response()->view('pageError');
        }
    }

    /**
     * @throws Exception
     */
    protected function searchRoute()
    {
        $this->preparePattern();
        if (preg_match($this->pattern, $this->path, $matches)) {
            array_shift($matches);
            $matches = array_filter($matches);
            $routeName = key($matches);
            $params = array_slice($matches, 2);

            if (isset($this->routeData[$routeName])) {
                $route = $this->routeData[$routeName];
                $handler = !empty($route['handler']) ? $route['handler'] : null;
                $method = !empty($route['method']) ? $route['method'] : 'GET';
                array_unshift($route['params'], 'request');
                array_unshift($params, $this->request);
                $params = !empty($params) ? array_combine($route['params'], $params) : [];
                return [
                    $handler,
                    $method,
                    $params
                ];
            } else {
                throw new Exception('Not existing route.', 404);
            }
        }
    }

    /**
     * Prepare patterns based on config.
     */
    protected function preparePattern()
    {
        $patterns = [];
        foreach ($this->routes as $route => $config) {
            $this->routeData[$route] = $config;
            $prepared = preg_replace('/\{([^:]+):([^}]+)\}/', '{$1}', $config['route']);

            $params = [];
            if (preg_match('/\{([^}]+)\}/', $prepared, $params)) {
                array_shift($params);
            }

            $this->routeData[$route]['params'] = $params;
            $pattern = preg_replace('/\{([^:]+):([^}]+)\}/', '($2)', $config['route']);
            $patterns[] = "(?P<{$route}>{$pattern})";
        }

        $pattern = implode(' | ', $patterns);
        $this->pattern = "~^(?: {$pattern} )$~x";
    }

    /**
     * Tries to fiend handler for such path.
     *
     * @param $handler
     * @param string $method
     * @return mixed
     * @throws Exception
     */
    protected function applyHandler($handler, $method = 'get', $params = [])
    {
        if (!empty($handler)) {
            if (strtolower($method) == strtolower($this->request->method)) {
                list($class, $method) = explode('::', $handler);
                if (class_exists($class)) {
                    $controller = new $class();
                    if (method_exists($controller, $method)) {
                        return call_user_func_array([$controller, $method], $params);
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