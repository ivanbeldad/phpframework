<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 04/12/2016
 * Time: 2:19
 */

namespace Akimah\Model;


class TableField
{

    const FIELD_INT = "INT";
    const FIELD_STRING = "CHAR";
    const FIELD_DECIMAL = "DECIMAL";

    protected $name;
    protected $size;
    protected $type;
    protected $autoIncrement;
    protected $primaryKey;
    protected $nullable;
    protected $value;

    function __construct($name, $type, $size)
    {
        $this->name = $name;
        $this->type = $type;
        $this->size = $size;
        $this->nullable = false;
        $this->autoIncrement = false;
        $this->primaryKey = false;
    }

    function autoIncrement()
    {
        $this->autoIncrement = true;
        return $this;
    }

    function primaryKey()
    {
        $this->primaryKey = true;
        return $this;
    }

    function nullable()
    {
        $this->nullable = true;
        return $this;
    }

}