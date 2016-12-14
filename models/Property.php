<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 04/12/2016
 * Time: 2:19
 */

namespace FrameworkIvan\Model;

use FrameworkIvan\Util\Cloner;

class Property implements PropertyCreator
{

    const FIELD_INT = 1;
    const FIELD_STRING = 2;
    const FIELD_DECIMAL = 3;
    const FIELD_DATE = 4;
    const FIELD_TIME = 5;
    const FIELD_DATETIME = 6;
    const FIELD_EMAIL = 7;
    const FIELD_BOOLEAN = 8;
    const FIELD_IMAGE = 9;

    protected $key;
    protected $size;
    protected $type;
    protected $autoIncrement;
    protected $primaryKey;
    protected $nullable;
    protected $defaultValue;
    protected $value;
    protected $foreignKey;
    protected $index;
    protected $unique;

    public function getKey()
    {
        return $this->key;
    }

    public function getSizeString()
    {
        return empty($this->size) ? "" : "(" . $this->size . ")";
    }

    public function getSize()
    {
        return $this->size;
    }

    public function isSize()
    {
        $size = $this->getSize();
        return isset($size);
    }

    public function getType()
    {
        return $this->type;
    }

    public function isAutoIncrement()
    {
        return $this->autoIncrement;
    }

    public function isPrimaryKey()
    {
        return $this->primaryKey;
    }

    public function isNullable()
    {
        return $this->nullable;
    }

    public function isDefaultValue()
    {
        return (!empty($this->defaultValue) || $this->defaultValue === 0);
    }

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getValueFormatted()
    {
        if ($this->type === Property::FIELD_IMAGE) {
            return "<img src='data:image/jpeg;base64, " . base64_encode($this->value) . "'>";
        } else {
            return $this->getValue();
        }
    }

    public function isValue()
    {
        $value = $this->value;
        return (isset($value) && $value !== "");
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function isForeignKey()
    {
        return isset($this->foreignKey);
    }

    /**
     * @return ForeignKeyAccess
     */
    public function getForeignKey()
    {
        return $this->foreignKey;
    }

    /**
     * @return boolean
     */
    public function isIndex()
    {
        return $this->index;
    }

    /**
     * @return boolean
     */
    public function isUnique()
    {
        return $this->unique;
    }

    // CREATOR INTERFACE

    public function __construct($name, $type, $size = null)
    {
        $this->key = $name;
        $this->type = $type;
        $this->size = $size;
        $this->nullable = false;
        $this->autoIncrement = false;
        $this->primaryKey = false;
        $this->index = false;
        $this->unique = false;
        $this->defaultValue = "";
        $this->foreignKey = null;
    }

    public function autoIncrement()
    {
        $this->autoIncrement = true;
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

    public function unique()
    {
        $this->unique = true;
    }

    public function index()
    {
        $this->index = true;
    }

    public function primaryKey()
    {
        $this->primaryKey = true;
        return $this;
    }

    public function foreignKey($name)
    {
        $this->index();
        $this->foreignKey = new ForeignKey($name, $this->key);
        return $this->foreignKey;
    }

}
