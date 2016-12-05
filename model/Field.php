<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 04/12/2016
 * Time: 2:19
 */

namespace Akimah\Model;


class Field
{

    const FIELD_INT = "INT";
    const FIELD_STRING = "CHAR";
    const FIELD_DECIMAL = "DECIMAL";
    const FIELD_DATE = "DATE";
    const FIELD_TIME = "TIME";
    const FIELD_DATETIME = "DATETIME";

    protected $name;
    protected $size;
    protected $type;
    protected $autoIncrement;
    protected $primaryKey;
    protected $nullable;
    protected $defaultValue;
    protected $value;

    public function __construct($name, $type, $size = null)
    {
        $this->name = $name;
        $this->type = $type;
        $this->size = $size;
        $this->nullable = false;
        $this->autoIncrement = false;
        $this->primaryKey = false;
        $this->defaultValue = "";
    }

    public function autoIncrement()
    {
        $this->autoIncrement = true;
        return $this;
    }

    public function primaryKey()
    {
        $this->primaryKey = true;
        return $this;
    }

    public function nullable()
    {
        $this->nullable = true;
        return $this;
    }

    public function defaultValue($value)
    {
        $this->defaultValue = $value;
        return $this;
    }

}