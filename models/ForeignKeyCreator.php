<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 07/12/2016
 * Time: 8:54
 */

namespace FrameworkIvan\Model;


interface ForeignKeyCreator
{

    /**
     * @param string $table
     * @return ForeignKeyCreator
     */
    public function references($table);

    /**
     * @param string $field
     * @return ForeignKeyCreator
     */
    public function on($field);

    /**
     * @param string $action
     * @return ForeignKeyCreator
     */
    public function onUpdate($action);

    /**
     * @param string $action
     * @return ForeignKeyCreator
     */
    public function onDelete($action);

}