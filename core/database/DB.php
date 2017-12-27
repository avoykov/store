<?php

namespace Av\Core\Database;

use PDO;

/**
 * Class Connection
 * @package Av\Core
 */
class DB
{
    /**
     * Instance of connection
     *
     * @var \Av\Core\Database\DB
     */
    private static $instance;

    /**
     * Redirect to pdo if is needed.
     *
     * @param $method
     * @param $args
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        if (method_exists(__CLASS__, $method)) {
            call_user_func_array(__NAMESPACE__ . "DB::{$method}", $args);

        } else {
            return call_user_func_array([self::getInstance(), $method], $args);
        }
    }

    /**
     * Returns instance of connection.
     *
     * @return \Av\Core\Database\DB
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            $params = require_once '../config/database.php';
            $str = sprintf("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
                $params['host'],
                $params['port'],
                $params['database'],
                $params['user'],
                $params['password']);

            $pdo = new PDO($str);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            static::$instance = $pdo;
        }

        return static::$instance;
    }

    /**
     * Gets one row and set it to specific object.
     *
     * @param $query
     * @param $class
     * @return mixed
     */
    public static function get($query, $class)
    {
        $pdo = self::getInstance();
        return $pdo->query($query)->fetchObject($class);
    }

    /**
     * Gets one row and set it to specific object.
     *
     * @param $query
     * @param $params
     * @param $class
     * @return mixed
     */
    public static function getMultiple($query, $params, $class)
    {
        $pdo = self::getInstance();
        $statement = $pdo->prepare($query);
        foreach ($params as $name => $value) {
            $statement->bindParam($name, $value, PDO::PARAM_INT);
        }
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $all = [];
        foreach ($result as $item) {

            if ($class) {
                $obj = new $class();
                $all[$item['id']] = $obj->fill($item);
            } else {
                $all[] = (object)$item;
            }
        }
        return $all;
    }

    /**
     * Get all results.
     *
     * @param $query
     * @param $class
     * @return array
     */
    public static function all($query, $class = null)
    {
        $pdo = self::getInstance();
        $statement = $pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $all = [];
        foreach ($result as $item) {

            if ($class) {
                $obj = new $class();
                $all[$item['id']] = $obj->fill($item);
            } else {
                $all[] = (object)$item;
            }
        }
        return $all;
    }

    /**
     * Execute run.
     *
     * @param $query
     * @param array $params
     * @return mixed
     */
    public static function run($query, $params = [])
    {
        $pdo = self::getInstance();
        if (empty($params)) {
            return $pdo->query($query)->execute();
        } else {
            $statement = $pdo->prepare($query);
            $result = $statement->execute($params);
            return $result ? $pdo->lastInsertId() : $result;
        }
    }

    /**
     * Execute run.
     *
     * @param $query
     * @return mixed
     */
    public static function fetch($query)
    {
        $pdo = self::getInstance();
        return $pdo->query($query)->fetchObject();
    }

    /**
     * Prevent cloning object.
     */
    protected function __clone()
    {
    }

}