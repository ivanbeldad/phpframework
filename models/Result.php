<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 05/12/2016
 * Time: 21:34
 */

namespace FrameworkIvan\Model;

use FrameworkIvan\Database\DatabaseFactory;


class Result
{

    /**
     * @var Table
     */
    private $table;
    /**
     * @var Table
     */
    private $origin;

    public function __construct(Table $table)
    {
        $this->origin = Table::getClone($table);
        $this->table = Table::getClone($table);
    }

    /**
     * @return Property[]
     */
    public function getFieldsAccess()
    {
        return $this->table->getProperties();
    }

    public function getFieldByKey($key)
    {
        foreach ($this->getFieldsAccess() as $fieldsAccess) {
            if (strtolower($fieldsAccess->getKey()) === strtolower($key)) {
                return $fieldsAccess;
            }
        }
        return null;
    }

    public function setProperty($key, $value)
    {
        $this->table->getProperty($key)->setValue($value);
        return $this;
    }

    private function setupValues($key, $value)
    {
        foreach ($this->origin->getProperties() as $fieldAccess) {
            if ($fieldAccess->getKey() === $key) $fieldAccess->setValue($value);
        }
        foreach ($this->table->getProperties() as $fieldAccess) {
            if ($fieldAccess->getKey() === $key) $fieldAccess->setValue($value);
        }
    }

    public function getPropertyValue($key)
    {
        return $this->table->getValue($key);
    }

    public static function assocArrayToResult(Table $structure, $assocArray)
    {
        $newResult = new Result($structure);
        foreach ($assocArray as $key => $value) {
            $newResult->setupValues($key, $value);
        }
        return $newResult;
    }

    public function update()
    {
        $db = DatabaseFactory::getDatabase();
        return $db->update($this->origin, $this->table);
    }

    public function delete()
    {
        $db = DatabaseFactory::getDatabase();
        return $db->delete($this->origin);
    }

}