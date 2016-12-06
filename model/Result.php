<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 05/12/2016
 * Time: 21:34
 */

namespace Akimah\Model;


class Result
{

    /**
     * @var AccessTable
     */
    private $structure;

    public function __construct(AccessTable $structure)
    {
        $this->structure = new AccessTable($structure);
    }

    /**
     * @return AccessProperty[]
     */
    public function getFieldsAccess()
    {
        return $this->structure->getFieldsAccess();
    }

    public function getFieldByKey($key)
    {
        foreach ($this->getFieldsAccess() as $fieldsAccess) {
            if ($fieldsAccess->getKey() === $key) return $fieldsAccess;
        }
        return null;
    }

    public function setValue($key, $value)
    {
        foreach ($this->structure->getFieldsAccess() as $fieldAccess) {
            if ($fieldAccess->getKey() === $key) $fieldAccess->setValue($value);
        }
    }

    public function getPropertyValue($key)
    {
        foreach ($this->structure->getFieldsAccess() as $fieldAccess) {
            if ($fieldAccess->getKey() === $key) return $fieldAccess->getValue();
        }
    }

    public static function rowToResult(AccessTable $structure, $row)
    {
        $newResult = new Result($structure);
        foreach ($row as $key => $value) {
            $newResult->setValue($key, $value);
        }
        return $newResult;
    }

}