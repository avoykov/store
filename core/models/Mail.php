<?php

namespace Av\core\models;

use Av\Core\Views\View;

/**
 * Class Mail
 * @package Av\core\models
 */
class Mail
{
    /**
     * @var
     */
    public $to;
    /**
     * @var
     */
    public $from;
    /**
     * @var
     */
    public $subject;
    /**
     * @var
     */
    public $message;
    /**
     * @var
     */
    public $view = 'mail';
    /**
     * @var array
     */
    public $viewParams = [];
    /**
     * @var array
     */
    public $headers = [];
    /**
     * @var array
     */
    public $params = [];

    /**
     * Helper for creating object.
     * @param $data
     * @return Mail
     */
    public static function create($data)
    {
        $obj = new static();
        if (!empty($obj->view)) {
            $obj->message = new View($obj->view, $obj->viewParams);
        }

        $version = phpversion();
        $obj->headers['xmailer'] = "X-mailer: {$version}";

        if (!empty($obj->from)) {
            $obj->headers['from'] = "From: {$obj->from}";

        }

        $obj->fill($data);

        return $obj;
    }

    /**
     * Fill object with attributes,
     *
     * @param array $data
     * @return mixed
     */
    public function fill($data = [])
    {
        foreach ($data as $name => $value) {
            $this->$name = $value;
        }

        return $this;
    }

    /**
     * Wrapper for mail.
     *
     * @return bool
     */
    public function send()
    {
        $header = implode("\r\n", $this->headers);
        return mail($this->to, $this->subject, $header, $this->params);
    }

}