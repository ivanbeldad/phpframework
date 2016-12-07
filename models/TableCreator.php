<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 07/12/2016
 * Time: 10:04
 */

namespace FrameworkIvan\Model;


interface TableCreator
{

    /**
     * @param string $name
     * @param int $length
     * @return PropertyCreator
     */
    public function int($name, $length);

    /**
     * @param string $name
     * @param int $max_length
     * @return PropertyCreator
     */
    public function string($name, $max_length);

    /**
     * @param string $name
     * @param int $max_length
     * @return PropertyCreator
     */
    public function email($name, $max_length);

    /**
     * @param string $name
     * @param int $digits
     * @param int $decimals
     * @return PropertyCreator
     */
    public function decimal($name, $digits, $decimals);

    /**
     * @param string $name
     * @return PropertyCreator
     */
    public function date($name);

    /**
     * @param string $name
     * @return PropertyCreator
     */
    public function time($name);

    /**
     * @param string $name
     * @return PropertyCreator
     */
    public function datetime($name);

    /**
     * @param string $name
     * @return PropertyCreator
     */
    public function boolean($name);

}