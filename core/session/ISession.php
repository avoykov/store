<?php

namespace Av\Core\Session;


interface ISession
{
    /**
     * Starts the session storage.
     *
     * @return bool
     */
    public function start();

    /**
     * Returns the session ID.
     *
     * @return string
     */
    public function getId();

    /**
     * Sets the session ID.
     *
     * @param string $id
     */
    public function setId($id);

    /**
     * Checks if an attribute is defined.
     *
     * @param string
     *
     * @return bool
     */
    public function has($name);

    /**
     * Returns an attribute.
     *
     * @param string $name The attribute name
     * @param mixed $default
     *
     * @return mixed
     */
    public function get($name, $default = null);

    /**
     * Sets an attribute.
     *
     * @param string $name
     * @param mixed $value
     */
    public function set($name, $value);

    /**
     * Returns attributes.
     *
     * @return array
     */
    public function all();

    /**
     * Removes an attribute.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function remove($name);

    /**
     * Clears all attributes.
     */
    public function clear();

    /**
     * Checks if the session was started.
     *
     * @return bool
     */
    public function isStarted();

}