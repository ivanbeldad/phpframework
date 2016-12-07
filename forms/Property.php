<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 06/12/2016
 * Time: 9:07
 */

namespace FrameworkIvan\Form;


class Property
{

    private $key;
    private $value;

    /**
     * Property constructor.
     * @param $key
     * @param $value
     */
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->getKey() . "='" . $this->getValue() . "'";
    }

}