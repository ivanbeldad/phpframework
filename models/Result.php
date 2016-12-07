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
     * @var AccessTable
     */
    private $structure;
    /**
     * @var AccessTable
     */
    private $origin;

    public function __construct(AccessTable $structure)
    {
        $this->origin = new AccessTable($structure);
        $this->structure = new AccessTable($structure);
    }

    /**
     * @return AccessProperty[]
     */
    public function getFieldsAccess()
    {
        return $this->structure->getProperties();
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
        $this->structure->getProperty($key)->setValue($value);
        return $this;
    }

    private function setupValues($key, $value)
    {
        foreach ($this->origin->getProperties() as $fieldAccess) {
            if ($fieldAccess->getKey() === $key) $fieldAccess->setValue($value);
        }
        foreach ($this->structure->getProperties() as $fieldAccess) {
            if ($fieldAccess->getKey() === $key) $fieldAccess->setValue($value);
        }
    }

    public function getPropertyValue($key)
    {
        return $this->structure->getValue($key);
    }

    public static function assocArrayToResult(AccessTable $structure, $assocArray)
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
        return $db->update($this->origin, $this->structure);
    }

    public function delete()
    {
        $db = DatabaseFactory::getDatabase();
        return $db->delete($this->origin);
    }

}