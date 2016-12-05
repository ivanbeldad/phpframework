<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 04/12/2016
 * Time: 2:19
 */

namespace Akimah\Model;


class Table
{

    protected $tableName;
    protected $tableFields = [];

    public function int($name, $length = 8)
    {
        $newField = new Field($name, Field::FIELD_INT, $length);
        array_push($this->tableFields, $newField);
        return $newField;
    }

    public function string($name, $max_length = 255)
    {
        $newField = new Field($name, Field::FIELD_STRING, $max_length);
        array_push($this->tableFields, $newField);
        return $newField;
    }

    public function decimal($name, $digits = 8, $decimals = 2)
    {
        $newField = new Field($name, Field::FIELD_DECIMAL, $digits . "," . $decimals);
        array_push($this->tableFields, $newField);
        return $newField;
    }

    public function date($name)
    {
        $newField = new Field($name, Field::FIELD_DATE);
        array_push($this->tableFields, $newField);
        return $newField;
    }

    public function time($name)
    {
        $newField = new Field($name, Field::FIELD_TIME);
        array_push($this->tableFields, $newField);
        return $newField;
    }

    public function datetime($name)
    {
        $newField = new Field($name, Field::FIELD_DATETIME);
        array_push($this->tableFields, $newField);
        return $newField;
    }

}