<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 04/12/2016
 * Time: 2:19
 */

namespace Akimah\Model;


class Table
{

    protected $tableFields = [];

    function int($name, $length = 8)
    {
        $newField = new TableField($name, TableField::FIELD_INT, $length);
        array_push($this->tableFields, $newField);
        return $newField;
    }

    function string($name, $max_length = 255)
    {
        $newField = new TableField($name, TableField::FIELD_STRING, $max_length);
        array_push($this->tableFields, $newField);
        return $newField;
    }

    function decimal($name, $digits = 8, $decimals = 2)
    {
        $newField = new TableField($name, TableField::FIELD_DECIMAL, $digits . "," . $decimals);
        array_push($this->tableFields, $newField);
        return $newField;
    }

}