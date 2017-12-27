<?php

namespace Av\Core\Models;

/**
 * Interface IModel
 * @package Av\core\models
 */
interface IModel
{
    /**
     * Creates new object and save it to db.
     *
     * @param array $data
     * @return IModel
     */
    static function create($data);

    /**
     * Returns object from database.
     *
     * @param $id
     * @param $column
     * @return IModel
     */
    static function load($id, $column = 'id');

    /**
     * Save data to database.
     *
     * @return IModel
     */
    function save();

    /**
     * Delete objects from database.
     *
     * @return null
     */
    function delete();

    /**
     * Updates object by input data.
     *
     * @param $data
     * @return IModel
     */
    function update($data);

    /**
     * Fill object with attributes,
     *
     * @param array $data
     * @return mixed
     */
    function fill($data = []);
}