<?php

namespace Av\Core;

use PDO;

/**
 * Class Connection
 * @package Av\Core
 */
class Connection
{
    /**
     * Instance of connection
     *
     * @var \Av\Core\Connection
     */
    private static $instance;
    /**
     * Config for connection to database.
     *
     * @var array
     */
    private $params = [];

    /**
     * Prevent straight creating of object.
     *
     * Connection constructor.
     */
    protected function __construct()
    {
        $this->params = require_once '../config/database.php';
    }

    /**
     * Returns instance of connection.
     *
     * @return Connection
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Open connection to database
     *
     * @return PDO
     */
    public function connect()
    {
        $str = sprintf("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
            $this->params['host'],
            $this->params['port'],
            $this->params['database'],
            $this->params['user'],
            $this->params['password']);

        $pdo = new PDO($str);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    /**
     * Prevent cloning object.
     */
    protected function __clone()
    {
    }

}