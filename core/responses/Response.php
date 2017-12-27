<?php

namespace Av\Core\Responses;

use Av\Core\Kernel;
use Av\Core\Views\View;

/**
 * Class Response
 * @package Av\Core
 */
class Response
{
    /**
     * Array of headers.
     * @var array
     */
    protected $headers = [];

    /**
     * Object which contains view for rendering.
     *
     * @var View
     */
    protected $view;

    /**
     * Response code.
     *
     * @var int
     */
    protected $code = 200;

    /**
     * Response message.
     *
     * @var string
     */
    protected $message;

    /**
     * Contains current request.
     *
     * @var \Av\Core\Requests\Request
     */
    protected $request;

    /**
     * Response constructor.
     * @param null $message
     * @param int $code
     */
    public function __construct($message = null, $code = 200)
    {
        $this->message = $message;
        $this->code = $code;
        $this->request = Kernel::getRequest();
    }

    /**
     * Helper for redirecting back.
     * @param array $params
     * @return Response
     */
    public function back($params = [])
    {
        foreach ($params as $name => $value) {
            $this->request->session->set($name, $value);
        }

        $this->redirect($this->request->getReferrer());
        return $this;
    }

    /**
     * Helper for implementing redirect
     *
     * @param string $path
     * @return Response
     */
    public function redirect($path = '/')
    {
        $this->code = '302';
        $this->addHeader('Location', $path);
        return $this;
    }

    /**
     * Helper for adding header.
     *
     * @param $name
     * @param $value
     * @return Response
     */
    public function addHeader($name, $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }

    /**
     * Helper for implementing view.
     *
     * @param $name
     * @param array $params
     * @return Response
     */
    public function view($name, $params = [])
    {
        $this->view = new View($name, $params);
        return $this;
    }

    /**
     * Helper for sending response.
     */
    public function send()
    {
        foreach ($this->getHeaders() as $name => $value) {
            header("{$name}: {$value}");
        }

        if (!empty($this->code)) {
            http_response_code($this->code);
        }

        if (!empty($this->view)) {
            $this->view->render();
        }

        if (!empty($this->message)) {
            print $this->message;
        }
        exit();
    }

    /**
     * Helper for getting headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Helper for setting headers.
     *
     * @param array $headers
     * @return Response
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }
}