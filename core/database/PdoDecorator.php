<?php

namespace Av\core\database;

use PDO;

/**
 * Class Database
 * @package Av\core\database
 */
class PdoDecorator
{

    /**
     * @var
     */
    protected $connection;

    /**
     * PdoDecorator constructor.
     * @param $connect
     */
    public function __construct($connect)
    {
        $this->connection = $connect;
    }

    /**
     * Gets one row and set it to specific object.
     *
     * @param $query
     * @param $class
     * @return mixed
     */
    public function get($query, $class)
    {
        return $this->connection->query($query)->fetchObject($class);
    }

    /**
     * Get all results.
     *
     * @param $query
     * @param $class
     * @return array
     */
    public function all($query, $class = null)
    {
        $statement = $this->connection->prepare($query);
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
     * Execute query.
     *
     * @param $query
     * @param array $params
     * @return mixed
     */
    public function query($query, $params = [])
    {
        if (empty($params)) {
            return $this->connection->query($query)->execute();
        } else {
            $statement = $this->connection->prepare($query);
            foreach ($params as $name => $value) {
                $statement->bindParam($name, $value);
            }
            return $statement->execute();
        }
    }


}