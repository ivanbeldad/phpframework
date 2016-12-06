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
    /**
     * @var AccessTable
     */
    private $structure;

    function __construct()
    {
        $this->setTableName($this->tableName);
        $this->setupStructure($this->structure);
    }

    static function create()
    {
        return new static();
    }

    // MODEL CONSTRUCTION BY OVERWRITING

    protected abstract function table(Table &$fields);

    protected abstract function setTableName(&$tableName);

    // ALLOW SET PROPERTIES

    public function setProperty($key, $value)
    {
        foreach ($this->structure->getAccessProperties() as $tableField) {
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
        return $db->createTable($object->structure);
    }

    public static function dropTable()
    {
        $object = new static();
        $db = DatabaseFactory::getDatabase();
        return $db->dropTable($object->structure);
    }

    // INSERT UPDATE AND DELETE RECORDS

    public function insert()
    {
        $db = DatabaseFactory::getDatabase();
        return $db->insert($this->structure);
    }

    // QUERIES

    public static function all()
    {
        $object = new static();
        $db = DatabaseFactory::getDatabase();
        return $db->all($object->structure);
    }

    static function find($id)
    {
        $object = new static();
        $database = DatabaseFactory::getDatabase();
        echo $query = "SELECT * FROM " . $object->structure->getTableName() . " WHERE id = '$id'";
        return $database->execute($query);
    }

    // FORMS

    public function getStructure()
    {
        return $this->structure;
    }

    // PRIVATE USAGE

    private function setupStructure(&$structure)
    {
        $table = new Table();
        $this->table($table);
        $tableAccess = new AccessTable($table);
        $tableAccess->setTableName($this->getTableName());
        $structure = $tableAccess;
    }

    private function getTableName()
    {
        return $this->tableName;
    }

}