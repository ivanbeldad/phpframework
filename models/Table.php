<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 04/12/2016
 * Time: 8:04
 */

namespace FrameworkIvan\Model;


class Table implements TableCreator
{

    /**
     * @var string
     */
    protected $tableName;
    /**
     * @var Property[]
     */
    protected $properties;

    function __construct()
    {
        $this->tableName = "";
        $this->properties = [];
    }

    public static function getClone(Table $table)
    {
        $newClone = new Table();
        $newClone->setTableName($table->tableName);
        foreach ($table->properties as $property) {
            array_push($newClone->properties, clone $property);
        }
        return $newClone;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * @return Property[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    public function invalidInsertRequirements()
    {
        foreach ($this->getProperties() as $field) {
            $value = $field->getValue();
            if (!isset($value) || $value === "") {
                if (!$field->isNullable() && !$field->isAutoIncrement() && !$field->isDefaultValue()) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getSettedKeys()
    {
        $names = [];
        foreach ($this->getProperties() as $tableField) {
            $value = $tableField->getValue();
            if (isset($value) && $value !== "") {
                array_push($names, $tableField->getKey());
            }
        }
        return $names;
    }

    /**
     * @return Property[]
     */
    public function getSettedValues()
    {
        $values = [];
        foreach ($this->getProperties() as $tableField) {
            $value = $tableField->getValue();
            if (isset($value) && $value !== "") {
                array_push($values, $value);
            }
        }
        return $values;
    }

    public function getProperty($key)
    {
        foreach ($this->properties as $accessProperty) {
            if ($accessProperty->getKey() === $key) return $accessProperty;
        }
        return null;
    }

    public function getValue($key)
    {
        if ($this->getProperty($key) === null) return null;
        return $this->getProperty($key)->getValue();
    }

    // CREATOR INTERFACE

    /**
     * @param string $name
     * @param int $length
     * @return PropertyCreator
     */
    public function int($name, $length = 8)
    {
        $newField = new Property($name, Property::FIELD_INT, $length);
        array_push($this->properties, $newField);
        return $newField;
    }

    /**
     * @param string $name
     * @param int $max_length
     * @return PropertyCreator
     */
    public function string($name, $max_length = 255)
    {
        $newField = new Property($name, Property::FIELD_STRING, $max_length);
        array_push($this->properties, $newField);
        return $newField;
    }

    /**
     * @param string $name
     * @param int $max_length
     * @return PropertyCreator
     */
    public function email($name, $max_length = 255)
    {
        $newField = new Property($name, Property::FIELD_EMAIL, $max_length);
        array_push($this->properties, $newField);
        return $newField;
    }

    /**
     * @param string $name
     * @param int $digits
     * @param int $decimals
     * @return PropertyCreator
     */
    public function decimal($name, $digits = 8, $decimals = 2)
    {
        $newField = new Property($name, Property::FIELD_DECIMAL, $digits . "," . $decimals);
        array_push($this->properties, $newField);
        return $newField;
    }

    /**
     * @param string $name
     * @return PropertyCreator
     */
    public function date($name)
    {
        $newField = new Property($name, Property::FIELD_DATE);
        array_push($this->properties, $newField);
        return $newField;
    }

    /**
     * @param string $name
     * @return PropertyCreator
     */
    public function time($name)
    {
        $newField = new Property($name, Property::FIELD_TIME);
        array_push($this->properties, $newField);
        return $newField;
    }

    /**
     * @param string $name
     * @return PropertyCreator
     */
    public function datetime($name)
    {
        $newField = new Property($name, Property::FIELD_DATETIME);
        array_push($this->properties, $newField);
        return $newField;
    }

    /**
     * @param string $name
     * @return PropertyCreator
     */
    public function boolean($name)
    {
        $newField = new Property($name, Property::FIELD_BOOLEAN, "1");
        array_push($this->properties, $newField);
        return $newField;
    }

    /**
     * @param string $name
     * @return PropertyCreator
     */
    public function image($name)
    {
        $newField = new Property($name, Property::FIELD_IMAGE);
        array_push($this->properties, $newField);
        return $newField;
    }

}
