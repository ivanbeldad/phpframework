<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 03/12/2016
 * Time: 7:14
 */

namespace FrameworkIvan\Model;

use FrameworkIvan\Database\DatabaseFactory;


abstract class Model
{

    private $tableName;
    /**
     * @var Table
     */
    private $table;

    function __construct()
    {
        $this->setTableName($this->tableName);
        $this->setupStructure($this->table);
    }

    static function create()
    {
        return new static();
    }

    // MODEL CONSTRUCTION BY OVERWRITING

    protected abstract function setTableName(&$tableName);

    protected abstract function table(TableCreator &$fields);

    // ALLOW SET PROPERTIES

    public function setProperty($key, $value)
    {
        foreach ($this->table->getProperties() as $tableField) {
            if ($tableField->getKey() === $key) {
                $tableField->setValue($value);
            }
        }
        return $this;
    }

    public function setProperties($assocArray)
    {
        foreach ($assocArray as $key => $value) {
            $this->setProperty($key, $value);
        }
        return $this;
    }

    // CREATE AND DROP TABLE

    public static function createTable()
    {
        $object = new static();
        $db = DatabaseFactory::getDatabase();
        return $db->createTable($object->table);
    }

    public static function dropTable()
    {
        $object = new static();
        $db = DatabaseFactory::getDatabase();
        return $db->dropTable($object->table);
    }

    // INSERT NEW OBJECTS IN DATABASE

    public function insert()
    {
        $db = DatabaseFactory::getDatabase();
        return $db->insert($this->table);
    }

    // QUERIES

    public static function all()
    {
        $object = new static();
        $db = DatabaseFactory::getDatabase();
        return $db->all($object->table);
    }

    public static function where($key, $value, $operator = "=")
    {
        $object = new static();
        $db = DatabaseFactory::getDatabase();
        return $db->where($object->table, $key, $value, $operator);
    }

    // FORMS

    public function getTable()
    {
        return $this->table;
    }

    // PRIVATE USAGE

    private function setupStructure(&$structure)
    {
        $table = new Table();
        $this->table($table);
        $table->setTableName($this->getTableName());
        $structure = $table;
    }

    private function getTableName()
    {
        return $this->tableName;
    }

}
