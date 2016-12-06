<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 04/12/2016
 * Time: 8:04
 */

namespace Akimah\Model;


class AccessTable extends Table
{

    /**
     * @var AccessProperty[]
     */
    protected $accessProperties;

    function __construct(Table $table)
    {
        $this->tableName = $table->tableName;
        $this->accessProperties = $this->convertFields($table);
    }

    private function convertFields(Table $table)
    {
        $accessFields = [];
        foreach($table->accessProperties as $tableField) {
            array_push($accessFields, new AccessProperty($tableField));
        }
        return $accessFields;
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
     * @return AccessProperty[]
     */
    public function getAccessProperties()
    {
        return $this->accessProperties;
    }

    public function showAll()
    {
        foreach ($this->getAccessProperties() as $field) {
            if (!$field instanceof AccessProperty) return;
            echo $field->toString() . "<br>";
        }
    }

    public function invalidInsertRequirements()
    {
        foreach($this->getAccessProperties() as $field) {
            $value = $field->getValue();
            if(!isset($value) || $value === "") {
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
        foreach ($this->getAccessProperties() as $tableField) {
            $value = $tableField->getValue();
            if(isset($value) && $value !== "") {
                array_push($names, $tableField->getKey());
            }
        }
        return $names;
    }

    public function getSettedValues()
    {
        $values = [];
        foreach ($this->getAccessProperties() as $tableField) {
            $value = $tableField->getValue();
            if(isset($value) && $value !== "") {
                array_push($values, "'" . $tableField->getValue() . "'");
            }
        }
        return $values;
    }

    public function getProperty($key)
    {
        foreach ($this->accessProperties as $accessProperty) {
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