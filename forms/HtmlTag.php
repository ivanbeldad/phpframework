<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 06/12/2016
 * Time: 9:10
 */

namespace Akimah\Form;
use Akimah\Model\AccessProperty;
use Akimah\Model;


class HtmlTag
{

    /**
     * @var string
     */
    private $element;
    /**
     * @var string
     */
    private $content;
    /**
     * @var Property[]
     */
    private $properties;

    public function __construct($tag = "", $content = "", $properties = [])
    {
        $this->element = $tag;
        $this->content = $content;
        if (count($properties) !== 0) {
            $this->properties = [];
            foreach ($properties as $key => $value) {
                array_push($this->properties, new Property($key, $value));
            }
        } else {
            $this->properties = [];
        }
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function addProperty($key, $value = "")
    {
        array_push($this->properties, new Property($key, $value));
        return $this;
    }

    /**
     * @param string $tag
     */
    public function setTag($tag)
    {
        $this->element = $tag;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    function __toString()
    {
        $oneReplace = 1;
        $string = "<" . $this->element . ">" . $this->content . "</" . $this->element . ">";
        foreach ($this->properties as $property) {
            $string = str_replace(">", " " . $property . ">", $string, $oneReplace);
        }
        return $string;
    }

}