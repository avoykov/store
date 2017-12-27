<?php

namespace Av\Core\Views;

use Av\Core\Kernel;

/**
 * Class View
 * @package Av\Core
 */
class View
{
    /**
     * Name of file.
     *
     * @var  string
     */
    protected $name;

    /**
     * Params which will be set to file
     *
     * @var array
     */
    protected $params = [];

    /**
     * Path to file.
     *
     * @var
     */
    protected $path;

    /**
     * Application root path.
     *
     * @var
     */
    protected $docRoot;

    /**
     * View constructor.
     * @param $name
     * @param array $params
     */
    public function __construct($name, $params = [])
    {
        $this->name = $name;
        $this->params = $params;
        $this->docRoot = Kernel::getRootDirectory();
        $this->preparePath();
    }

    /**
     *  Helper for getting path to view.
     */
    protected function preparePath()
    {
        $path = str_replace('.', '/', $this->name);
        $this->path = "{$this->docRoot}views/{$path}.php";
    }

    /**
     *  Handle converting to string.
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Helper for rendering a template.
     *
     * @return string
     */
    public function render()
    {
        if (file_exists($this->path)) {
            extract($this->params);
            return require_once($this->path);
        }
        return '';
    }

}