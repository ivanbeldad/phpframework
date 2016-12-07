<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 04/12/2016
 * Time: 3:38
 */

namespace FrameworkIvan\Model;

use FrameworkIvan\Util\Cloner;


class AccessProperty extends Property
{

    public function __construct(Property $tableField)
    {
        Cloner::cloneProperties($tableField, $this);
    }

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

}