<?php

namespace Av\Core\Requests;

use Av\Core\Session\Session;


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
     * Session wrapper.
     *
     * @var ISession
     */
    public $session;

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
     * Domain.
     *
     * @var mixed
     */
    public $domain;
    /**
     * Scheme.
     * @var string
     */
    public $scheme;

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
            $this->session = new Session();

            $this->method = strtolower($server['REQUEST_METHOD']);
            $this->path = $server['REQUEST_URI'];
            $this->domain = isset($server['HTTP_HOST']) ? $server['HTTP_HOST'] : $server['SERVER_NAME'];
            $this->scheme = isset($server['REQUEST_SCHEME']) ? $server['REQUEST_SCHEME'] : 'http';
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

    /**
     * Helper for validating CSRF token.
     */
    public function validateCsrf()
    {
        if ($token = $this->get('csrf_token')) {
            return $token === $this->session->get('csrf_token');
        } else {
            return true;
        }
    }

    /**
     * Helper for getting data from request.
     *
     * @param $name
     * @param null $default
     * @return mixed|null
     */
    public function get($name, $default = null)
    {
        $result = [];
        switch ($this->method) {
            case 'post':
                $this->getParam($name, $this->request, $result);
                break;

            case 'get':
                $this->getParam($name, $this->query, $result);
                break;
        }

        foreach ($result as &$item) {
            $item = filter_var($item, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        if (count($result) == 1) {
            $result = reset($result);
        }
        return !empty($result) || $result == '0' ? $result : $default;
    }

    /**
     * Helper for getting params in recursive way.
     *
     * @param $name
     * @param $source
     * @param $result
     */
    protected function getParam($name, $source, &$result)
    {
        foreach ($source as $index => $item) {
            if ($index == $name) {
                $result[] = $item;
            } elseif (is_array($item)) {
                $this->getParam($name, $item, $result);
            }
        }
    }

    /**
     * Helper for getting all values.
     *
     * @return array
     */
    public function all()
    {
        $result = [];
        switch ($this->method) {
            case 'post':
                foreach ($this->request as $name => $value) {
                    $result[$name] = filter_input(INPUT_POST, $name, FILTER_SANITIZE_SPECIAL_CHARS);
                }
                return $result;
            case 'get':
                foreach ($this->request as $name => $value) {
                    $result[$name] = filter_input(INPUT_GET, $name, FILTER_SANITIZE_SPECIAL_CHARS);
                }
                return $result;
            default:
                return [];
        }
    }

    /**
     * Validates input.
     *
     * @param $rules
     * @param $messages
     * @return bool
     */
    public function validate($rules, &$messages)
    {
        foreach ($rules as $name => $data) {
            $variable = $this->get($name);
            if (is_array($variable)) {
                foreach ($variable as $item) {
                    $options = $data['options'] ? $data['options'] : [];
                    if (!filter_var($item, $data['filter'], $options)) {
                        $messages[$name] = $data['message'];
                    }
                }
            } elseif (!filter_var($variable, $data['filter'])) {
                $messages[$name] = $data['message'];
            }
        }
        return empty($messages);
    }

    /**
     * Helper which returns Referrer.
     */
    public function getReferrer()
    {
        return isset($this->server['HTTP_REFERER']) ? $this->server['HTTP_REFERER'] : null;

    }
}