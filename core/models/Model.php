<?php

namespace Av\Core\Models;

use Av\Core\Database\DB;
use Exception;

/**
 * Class Model
 * @package Av\Core\Models
 */
class Model implements IModel
{
    /**
     * Table name.
     *
     * @var string
     */
    protected static $tableName;

    /**
     * Id of model.
     *
     * @var string
     */
    protected $id;

    /**
     * Field which should be ignored.
     *
     * @var array
     */
    protected static $ignore = [];

    /**
     * @inheritdoc
     */
    public static function create($data)
    {
        $obj = new static();
        $obj->fill($data);
        return $obj->save();
    }

    /**
     * Fill object with attributes,
     *
     * @param array $data
     * @return mixed
     */
    function fill($data = [])
    {
        foreach ($data as $name => $value) {
            $this->$name = $value;
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        $tableName = static::$tableName;

        $attrs = [];
        foreach (get_object_vars($this) as $name => $value) {
            if (!is_null($value) && !in_array($name, static::$ignore)) {
                $attrs[$name] = $value;
            }
        }

        if (isset($this->id)) {
            $this->update($attrs);
        }

        $params = array_values($attrs);

        $placeholders = array_fill(0, count($attrs), '?');
        $placeholders = implode(',', $placeholders);

        $keys = array_keys($attrs);
        $keys = implode(',', $keys);


        $query = "INSERT INTO {$tableName} ({$keys}) VALUES({$placeholders})";
        $result = DB::run($query, $params);
        if (empty($this->getId())) {
            $this->setId($result);
        }
        return $result ? $this : $result;

    }

    /**
     * @inheritdoc
     */
    public function update($data = [])
    {
        if (!empty($data) || empty($this->id)) {
            $tableName = static::$tableName;
            $values = [];
            $params = [];
            foreach ($data as $name => $value) {
                if ($name == 'id') {
                    continue;
                }
                $values[] = "{$name} = :{$name}";
                $params[":{$name}"] = $value;
            }
            $params[':id'] = $this->id;
            $values = implode(',', $values);
            $query = "UPDATE {$tableName} SET {$values} WHERE id = :id";
            $result = DB::run($query, $params);
            return $result ? $this : $result;
        } else {
            return false;
        }
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @inheritdoc
     */
    public static function load($id, $column = 'id')
    {
        $tableName = static::$tableName;
        $model = get_called_class();
        if (is_array($id)) {
            $id = implode(', ', $id);
            $query = "SELECT * FROM {$tableName} WHERE {$column} IN ({$id})";
            $result = DB::getMultiple($query, [], $model);
        } else {
            $query = "SELECT * FROM {$tableName} WHERE {$column} = {$id}";

            $result = DB::get($query, $model);
            if (empty($result)) {
                throw new Exception('Not existing instance.');
            }
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public static function exists($id)
    {
        $tableName = static::$tableName;
        $query = "SELECT 1 FROM {$tableName} WHERE id = {$id}";
        $result = DB::fetch($query);
        return !empty($result);
    }

    /**
     * @inheritdoc
     */
    public static function all($limit = null)
    {
        $tableName = static::$tableName;
        $query = "SELECT * FROM {$tableName} ORDER BY RANDOM()";
        if (!empty($limit)) {
            $query .= " LIMIT {$limit}";
        }
        $model = get_called_class();

        return DB::all($query, $model);
    }

    /**
     * @inheritdoc
     */
    public function delete()
    {
        if (!empty($this->id)) {
            $tableName = static::$tableName;
            $query = "SELECT * FROM {$tableName} WHERE id = {$this->id}";
            DB::query($query);
            return $this->id;
        } else {
            return false;
        }
    }
}