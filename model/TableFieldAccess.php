<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 04/12/2016
 * Time: 3:38
 */

namespace Akimah\Model;


class TableFieldAccess extends TableField
{

    public $name;
    private $tableField;

    public function __construct(TableField $tableField)
    {
        $this->tableField = $tableField;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->tableField->name;
    }

    /**
     * @return string
     */
    public function getSize()
    {
        return $this->tableField->size;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->tableField->type;
    }

    /**
     * @return string
     */
    public function isAutoIncrementString()
    {
        return $this->tableField->autoIncrement ? "AUTO_INCREMENT" : "";
    }

    /**
     * @return string
     */
    public function isPrimaryKeyString()
    {
        return $this->tableField->primaryKey ? "PRIMARY KEY" : "";
    }

    /**
     * @return string
     */
    public function isNullableString()
    {
        return $this->tableField->nullable ? "" : "NOT NULL";
    }

    /**
     * @return boolean
     */
    public function isAutoIncrement()
    {
        return $this->tableField->autoIncrement;
    }

    /**
     * @return boolean
     */
    public function isPrimaryKey()
    {
        return $this->tableField->primaryKey;
    }

    /**
     * @return boolean
     */
    public function isNullable()
    {
        return $this->tableField->nullable;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->tableField->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->tableField->value = $value;
    }


    /**
     * @return string
     */
    public function toString()
    {
        $string = "";
        $string .= "Name: " . $this->tableField->name . "<br>";
        $string .= "Size: " . $this->tableField->size . "<br>";
        $string .= "Type: " . $this->tableField->type . "<br>";
        $string .= "AutoIncrement: " . $this->tableField->autoIncrement . "<br>";
        $string .= "Primary Key: " . $this->tableField->primaryKey . "<br>";
        $string .= "Nullable: " . $this->tableField->nullable . "<br>";
        return $string;
    }

}