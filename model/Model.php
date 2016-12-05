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

    private $tableName;
    private $structure;

    function __construct()
    {
        $this->setTableName($this->tableName);
        $this->setupStructure($this->structure);
    }

    static function find($id)
    {
        $object = new static();
        $database = DatabaseFactory::getDatabase();
        echo $query = "SELECT * FROM " . $object->structure->getTableName() . " WHERE id = '$id'";
        return $database->execute($query);
    }

    public static function createTable()
    {
        $object = new static();
        $db = DatabaseFactory::getDatabase();
        return $db->createTable($object->structure);
    }

    public static function dropTable()
    {
        $object = new static();
        $db = DatabaseFactory::getDatabase();
        return $db->dropTable($object->structure);
    }

    public function insert()
    {
        $db = DatabaseFactory::getDatabase();
        return $db->insert($this->structure);
    }

    private function setupStructure(&$structure)
    {
        $table = new Table();
        $this->table($table);
        $tableAccess = new TableAccess($table);
        $tableAccess->setTableName($this->getTableName());
        $structure = $tableAccess;
    }

    public function setProperty($name, $value)
    {
        foreach ($this->structure->getTableFields() as $tableField) {
            if ($tableField->getName() === $name) {
                $tableField->setValue($value);
            }
        }
    }

    public function setProperties($assocArray)
    {
        foreach ($assocArray as $key => $value) {
            $this->setProperty($key, $value);
        }
    }

    protected abstract function table(Table &$fields);

    protected abstract function setTableName(&$tableName);

    private function getTableName()
    {
        return $this->tableName;
    }

}