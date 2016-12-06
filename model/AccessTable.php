<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 04/12/2016
 * Time: 8:04
 */

namespace Akimah\Model;


class AccessTable extends Table
{

    function __construct(Table $table)
    {
        $this->tableName = $table->tableName;
        $this->fieldsAccess = $this->convertFields($table);
    }

    private function convertFields(Table $table)
    {
        $accessFields = [];
        foreach($table->fieldsAccess as $tableField) {
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
    public function getFieldsAccess()
    {
        return $this->fieldsAccess;
    }

    public function showAll()
    {
        foreach ($this->getFieldsAccess() as $field) {
            if (!$field instanceof AccessProperty) return;
            echo $field->toString() . "<br>";
        }
    }

    public function invalidInsertRequirements()
    {
        foreach($this->getFieldsAccess() as $field) {
            $value = $field->getValue();
            if(!isset($value) || $value === "") {
                if (!$field->isNullable() && !$field->isAutoIncrement() && !$field->isDefaultValue()) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getAllSettedNames()
    {
        $names = [];
        foreach ($this->getFieldsAccess() as $tableField) {
            $value = $tableField->getValue();
            if(isset($value) && $value !== "") {
                array_push($names, $tableField->getKey());
            }
        }
        return $names;
    }

    public function getAllSettedValues()
    {
        $values = [];
        foreach ($this->getFieldsAccess() as $tableField) {
            $value = $tableField->getValue();
            if(isset($value) && $value !== "") {
                array_push($values, "'" . $tableField->getValue() . "'");
            }
        }
        return $values;
    }

}