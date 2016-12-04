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
     * @return array
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

}