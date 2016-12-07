<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 07/12/2016
 * Time: 3:05
 */

namespace FrameworkIvan\Model;


class ForeignKey
{

    const ACTION_RESTRICT = 1;
    const ACTION_CASCADE = 2;
    const ACTION_NO_ACTION = 3;
    const ACTION_SET_NULL = 4;

    private $constraint;
    private $referenceTable;
    private $keyFrom;
    private $keyTo;
    private $onUpdate;
    private $onDelete;

    public function __construct(
        $constraint,
        $fieldFrom = null,
        $fieldTo = null,
        $referenceTable = null,
        $onUpdate = ForeignKey::ACTION_CASCADE,
        $onDelete = ForeignKey::ACTION_RESTRICT)
    {
        $this->constraint = $constraint;
        $this->referenceTable = $referenceTable;
        $this->keyFrom = $fieldFrom;
        $this->keyTo = $fieldTo;
        $this->onUpdate = $onUpdate;
        $this->onDelete = $onDelete;
    }

    /**
     * @return string
     */
    public function getConstraint()
    {
        return $this->constraint;
    }

    /**
     * @return string
     */
    public function getReferenceTable()
    {
        return $this->referenceTable;
    }

    /**
     * @return string
     */
    public function getKeyFrom()
    {
        return $this->keyFrom;
    }

    /**
     * @return string
     */
    public function getKeyTo()
    {
        return $this->keyTo;
    }

    /**
     * @return int
     */
    public function getOnUpdate()
    {
        return $this->onUpdate;
    }

    /**
     * @return int
     */
    public function getOnDelete()
    {
        return $this->onDelete;
    }

    // CREATOR INTERFACE

    public function references($table)
    {
        $this->referenceTable = $table;
        return $this;
    }

    public function on($field)
    {
        $this->keyTo = $field;
        return $this;
    }

    public function onUpdate($action)
    {
        $this->onUpdate = $action;
        return $this;
    }

    public function onDelete($action)
    {
        $this->onDelete = $action;
        return $this;
    }

}