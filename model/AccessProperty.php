<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 04/12/2016
 * Time: 3:38
 */

namespace Akimah\Model;


class AccessProperty extends Property
{

    public function __construct(Property $tableField)
    {
        $this->key = $tableField->key;
        $this->type = $tableField->type;
        $this->size = $tableField->size;
        $this->nullable = $tableField->nullable;
        $this->autoIncrement = $tableField->autoIncrement;
        $this->primaryKey = $tableField->primaryKey;
        $this->defaultValue = $tableField->defaultValue;
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

    public function getType()
    {
        return $this->type;
    }

    public function isAutoIncrementString()
    {
        return $this->autoIncrement ? "AUTO_INCREMENT" : "";
    }

    public function isPrimaryKeyString()
    {
        return $this->primaryKey ? "PRIMARY KEY" : "";
    }

    public function isNullableString()
    {
        return $this->nullable ? "" : "NOT NULL";
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
        return !empty($this->defaultValue);
    }

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    public function getDefaultValueString()
    {
        return empty($this->defaultValue) ? "" : "DEFAULT '" . $this->defaultValue . "'";
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function toString()
    {
        $string = "";
        $string .= "Name: " . $this->key . "<br>";
        $string .= "Size: " . $this->size . "<br>";
        $string .= "Type: " . $this->type . "<br>";
        $string .= "AutoIncrement: " . $this->autoIncrement . "<br>";
        $string .= "Primary Key: " . $this->primaryKey . "<br>";
        $string .= "Nullable: " . $this->nullable . "<br>";
        return $string;
    }

}