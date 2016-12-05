<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 04/12/2016
 * Time: 8:04
 */

namespace Akimah\Model;


class TableAccess extends Table
{

    private $table;

    function __construct(Table $table = null)
    {
        $this->table = $table;
        if($this->table === null) $this->table = new Table();
    }

    /**
     * @return TableFieldAccess[]
     */
    public function getTableFields()
    {
        $accessFields = [];
        foreach($this->table->tableFields as $tableField) {
            array_push($accessFields, new TableFieldAccess($tableField));
        }
        return $accessFields;
    }

    function showAll()
    {
        foreach ($this->getTableFields as $field) {
            if (!$field instanceof TableFieldAccess) return;
            echo $field->toString() . "<br>";
        }
    }

    function invalidInsertRequirements()
    {
        foreach($this->getTableFields() as $field) {
            $value = $field->getValue();
            if(!isset($value) || $value === "") {
                if (!$field->isNullable() && !$field->isAutoIncrement()) {
                    return true;
                }
            }
        }
        return false;
    }

    function getAllSettedNames()
    {
        $names = [];
        foreach ($this->getTableFields() as $tableField) {
            $value = $tableField->getName();
            if(isset($value) && $value !== "") {
                array_push($names, $tableField->getName());
            }
        }
        return $names;
    }

    function getAllSettedValues()
    {
        $values = [];
        foreach ($this->getTableFields() as $tableField) {
            $value = $tableField->getName();
            if(isset($value) && $value !== "") {
                array_push($values, "'" . $tableField->getValue() . "'");
            }
        }
        return $values;
    }

}