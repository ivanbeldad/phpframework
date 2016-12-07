<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 07/12/2016
 * Time: 3:05
 */

namespace Akimah\Model;


use Akimah\Database\Cloner;

class ForeignKeyAccess extends ForeignKey
{

    public function __construct(ForeignKey $foreignKey)
    {
        Cloner::cloneProperties($foreignKey, $this);
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

}