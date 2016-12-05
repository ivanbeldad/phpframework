<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 03/12/2016
 * Time: 7:14
 */

namespace Akimah\Model;
use Akimah\Database\DatabaseFactory;


abstract class Model
{

    protected $table;

    static function find($id)
    {
        $object = new static();
        $database = DatabaseFactory::getDatabase();
        echo $query = "SELECT * FROM " . $object->table . " WHERE id = '$id'";
        return $database->execute($query);
    }

    abstract protected function table(Table &$fields);

    static function createTable()
    {
        $object = new static();
        $tableStructure = new Table();
        $object->table($tableStructure);
        $tableStructure = new TableAccess($tableStructure);
        return DatabaseFactory::getDatabase()->createTable($object->table, $tableStructure);
    }

    static function dropTable()
    {
        $object = new static();
        return DatabaseFactory::getDatabase()->dropTable($object->table);
    }

    function insert()
    {
        $db = DatabaseFactory::getDatabase();
        return $db->insert($this->table, $this->getStructureWithValues());
    }

    function getStructureWithValues()
    {
        $table = new Table();
        $this->table($table);
        $tableAccess = new TableAccess($table);
        foreach($tableAccess->getTableFields() as $field) {
            if (isset($this->{$field->getName()})) {
                $field->setValue($this->{$field->getName()});
            }
        }
        return $tableAccess;
    }

}