<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 07/12/2016
 * Time: 9:30
 */

namespace FrameworkIvan\Model;


interface PropertyCreator
{

    /**
     * @return PropertyCreator
     */
    public function autoIncrement();

    /**
     * @return PropertyCreator
     */
    public function nullable();

    /**
     * @param $value
     * @return PropertyCreator
     */
    public function defaultValue($value);

    /**
     * @return PropertyCreator
     */
    public function unique();

    /**
     * @return PropertyCreator
     */
    public function index();

    /**
     * @return PropertyCreator
     */
    public function primaryKey();

    /**
     * @param string $name
     * @return ForeignKeyCreator
     */
    public function foreignKey($name);

}