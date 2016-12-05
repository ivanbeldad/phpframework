<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 04/12/2016
 * Time: 8:04
 */

namespace Akimah\Model;


class TableAccess extends Table
{

    function __construct(Table $table)
    {
        $this->tableName = $table->tableName;
        $this->tableFields = $this->convertFields($table);
    }

    private function convertFields(Table $table)
    {
        $accessFields = [];
        foreach($table->tableFields as $tableField) {
            array_push($accessFields, new FieldAccess($tableField));
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

    public function getTableFields()
    {
        return $this->tableFields;
    }

    public function showAll()
    {
        foreach ($this->getTableFields() as $field) {
            if (!$field instanceof FieldAccess) return;
            echo $field->toString() . "<br>";
        }
    }

    public function invalidInsertRequirements()
    {
        foreach($this->getTableFields() as $field) {
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
        foreach ($this->getTableFields() as $tableField) {
            $value = $tableField->getValue();
            if(isset($value) && $value !== "") {
                array_push($names, $tableField->getName());
            }
        }
        return $names;
    }

    public function getAllSettedValues()
    {
        $values = [];
        foreach ($this->getTableFields() as $tableField) {
            $value = $tableField->getValue();
            if(isset($value) && $value !== "") {
                array_push($values, "'" . $tableField->getValue() . "'");
            }
        }
        return $values;
    }

}