<?php

namespace Av\Core\Models;

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
    private static $tableName;

    /**
     * Id of model.
     *
     * @var string
     */
    protected $id;

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
        $attrs = get_object_vars($this);
        if (isset($this->id)) {
            $this->update($attrs);
        }

        $tableName = static::$tableName;
        $params = $values = [];
        $attrs = array_filter($attrs);
        $keys = array_keys($attrs);
        foreach ($attrs as $name => $value) {
            $placeholder = ":{$name}";
            $params[$placeholder] = $value;
            $values[] = $placeholder;
        }
        $values = implode(',', $values);
        $keys = implode(',', $keys);
        $query = "INSERT INTO {$tableName} ({$keys}) VALUES({$values})";
        $result = DB()->query($query, $params);
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
            $result = DB()->query($query, $params);
            return $result ? $this : $result;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public static function load($id)
    {
        $tableName = static::$tableName;
        $query = "SELECT * FROM {$tableName} WHERE id = {$id}";
        $model = get_called_class();
        return DB()->get($query, $model);
    }

    /**
     * @inheritdoc
     */
    public static function all($limit = null)
    {
        $tableName = static::$tableName;
        $query = "SELECT * FROM {$tableName}";
        if (!empty($limit)) {
            $query .= " LIMIT {$limit}";
        }
        $model = get_called_class();

        return DB()->all($query, $model);
    }

    /**
     * @inheritdoc
     */
    public function delete()
    {
        if (!empty($this->id)) {
            $tableName = static::$tableName;
            $query = "SELECT * FROM {$tableName} WHERE id = {$this->id}";
            DB()->query($query);
            return $this->id;
        } else {
            return false;
        }
    }
}