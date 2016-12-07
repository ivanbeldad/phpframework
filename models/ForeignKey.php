<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 07/12/2016
 * Time: 2:59
 */

namespace FrameworkIvan\Model;


class ForeignKey
{

    const ACTION_RESTRICT = 1;
    const ACTION_CASCADE = 2;
    const ACTION_NO_ACTION = 3;
    const ACTION_SET_NULL = 4;

    protected $constraint;
    protected $referenceTable;
    protected $keyFrom;
    protected $keyTo;
    protected $onUpdate;
    protected $onDelete;

    /**
     * ForeignKey constructor.
     * @param $constraint
     * @param $referenceTable
     * @param $fieldFrom
     * @param $fieldTo
     * @param $onUpdate
     * @param $onDelete
     */
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