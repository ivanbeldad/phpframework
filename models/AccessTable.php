<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 04/12/2016
 * Time: 8:04
 */

namespace FrameworkIvan\Model;


class AccessTable extends Table
{

    /**
     * @var Property[]
     */
    protected $properties;

    function __construct(Table $table)
    {
        $this->tableName = $table->tableName;
        $this->properties = $this->convertFields($table);
    }

    private function convertFields(Table $table)
    {
        $accessFields = [];
        foreach ($table->properties as $property) {
            array_push($accessFields, Property::getClone($property));
        }
        return $accessFields;
    }

//    private function convertFields(Table $table)
//    {
//        $accessFields = [];
//        foreach ($table->accessProperties as $tableField) {
//            array_push($accessFields, new AccessProperty($tableField));
//        }
//        return $accessFields;
//    }

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

}