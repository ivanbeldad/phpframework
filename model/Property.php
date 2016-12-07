<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 04/12/2016
 * Time: 2:19
 */

namespace Akimah\Model;


class Property
{

    const FIELD_INT = 1;
    const FIELD_STRING = 2;
    const FIELD_DECIMAL = 3;
    const FIELD_DATE = 4;
    const FIELD_TIME = 5;
    const FIELD_DATETIME = 6;
    const FIELD_EMAIL = 7;
    const FIELD_BOOLEAN = 8;

    protected $key;
    protected $size;
    protected $type;
    protected $autoIncrement;
    protected $primaryKey;
    protected $nullable;
    protected $defaultValue;
    protected $value;

    public function __construct($name, $type, $size = null)
    {
        $this->key = $name;
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
        if ($value === true) $value = 1;
        if ($value === false) $value = 0;
        $this->defaultValue = $value;
        return $this;
    }

}