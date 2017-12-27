<?php

namespace Av\Core\Session;

use Exception;

/**
 * Class Session
 * @package Av\core\session
 */
class Session implements ISession
{

    /**
     * Session constructor.
     */
    public function __construct()
    {
        $options = [
            'cache_limiter' => '',
            'cache_expire' => 0,
            'use_cookies' => 1,
            'lazy_write' => 1,
        ];

        session_register_shutdown();
        foreach ($options as $name => $value) {
            ini_set('session.' . $name, $value);
        }

    }


    /**
     * Starts the session.
     *
     * @return bool
     * @throws Exception
     */
    public function start()
    {

        if ($this->isStarted() || headers_sent()) {
            throw new Exception('Session already started or sent.');
        }

        return session_start();
    }

    /**
     * Checks if the session was started.
     *
     * @return bool
     */
    public function isStarted()
    {
        return session_status() === \PHP_SESSION_ACTIVE;
    }

    /**
     * Returns the session ID.
     *
     * @return string
     */
    public function getId()
    {
        return session_id();
    }

    /**
     * Sets the session ID.
     *
     * @param string $id
     */
    public function setId($id)
    {
        session_id($id);
    }

    /**
     * Checks if an attribute is defined.
     *
     * @param string
     *
     * @return bool
     */
    public function has($name)
    {
        return isset($_SESSION[$name]);
    }

    /**
     * Returns an error.
     *
     *
     * @return mixed
     */
    public function getErrors()
    {
        if (!empty($_SESSION['errors'])) {
            $errors = $_SESSION['errors'];
            unset($_SESSION['errors']);
            return $errors;
        }
        return [];
    }

    /**
     * Returns attributes.
     *
     * @return array
     */
    public function all()
    {
        return array_values($_SESSION);
    }

    /**
     * Clears all attributes.
     */
    public function clear()
    {
        $_SESSION = array();
    }

    /**
     * Helper for adding product to order.
     *
     * @param $id
     */
    public function addProduct($id)
    {
        $order = $this->get('order', []);
        $order[$id] = isset($order[$id]) ? $order[$id] + 1 : 1;
        $this->set('order', $order);
    }

    /**
     * Returns an attribute.
     *
     * @param string $name The attribute name
     * @param mixed $default
     *
     * @return mixed
     */
    public function get($name, $default = null)
    {
        return !empty($_SESSION[$name]) ? $_SESSION[$name] : $default;
    }

    /**
     * Sets an attribute.
     *
     * @param string $name
     * @param mixed $value
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Helper for removing product from order.
     * @param $id
     * @param bool $complete
     */
    public function removeProduct($id, $complete = false)
    {
        $order = $this->get('order', []);
        if (!$complete) {
            $order[$id] = isset($order[$id]) && $order[$id] > 0 ? $order[$id] - 1 : $order[$id];
        } else {
            unset($order[$id]);
        }
        $this->set('order', $order);
    }

    /**
     * Helper for setting quantity.
     *
     * @param $id
     * @param $quantity
     */
    public function setQuantity($id, $quantity)
    {
        $order = $this->get('order', []);
        $order[$id] = $quantity;
        $this->set('order', $order);
    }

    /**
     * Helper for clearing order.
     */
    public function clearOrder()
    {
        $this->set('order', []);
        $this->remove('bonus');
    }

    /**
     * Removes an attribute.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function remove($name)
    {
        unset($_SESSION[$name]);
    }

    /**
     * Helper for getting all products.
     *
     * @return mixed
     */
    public function getProducts()
    {
        return $this->get('order', []);
    }
}