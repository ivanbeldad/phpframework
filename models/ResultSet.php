<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 05/12/2016
 * Time: 21:33
 */

namespace Akimah\Model;
use Exception;

class ResultSet
{

    /**
     * @var Result[]
     */
    private $results;
    private $length;

    public function __construct()
    {
        $this->results = [];
        $this->length = 0;
    }

    public function addResult(Result $result)
    {
        array_push($this->results, $result);
        $this->length++;
    }

    /**
     * @return Result
     * @throws Exception "There are any results."
     */
    public function first()
    {
        if ($this->isEmpty()) throw new EmptyResultsException();
        return $this->results[0];
    }

    /**
     * @return Result
     * @throws Exception
     */
    public function last()
    {
        if ($this->isEmpty()) throw new EmptyResultsException();
        return $this->results[$this->length - 1];
    }

    /**
     * @param $key
     * @return $this
     * @throws InvalidKeyException
     */
    public function sortBy($key)
    {
        if ($this->length <= 1) return $this;
        if ($this->first()->getPropertyValue($key) === null) throw new InvalidKeyException();
        usort($this->results, function ($a, $b) use ($key) {
            if (!$a instanceof Result || !$b instanceof Result) return;
            $aValue = null;
            $bValue = null;
            $aField =$a->getFieldByKey($key);
            $bField =$b->getFieldByKey($key);
            if ($aField->getKey() === $key) $aValue = $aField->getValue();
            if ($bField->getKey() === $key) $bValue = $bField->getValue();
            if ($aField->getType() === Property::FIELD_DECIMAL || $aField->getType() === Property::FIELD_INT) {
                return $aValue - $bValue;
            } else {
                return strcmp($aValue, $bValue);
            }
        });
        return $this;
    }

    public function reverse()
    {
        $this->results = array_reverse($this->results);
        return $this;
    }

    public function bigger($key, $value)
    {
        for ($i = 0; $i < $this->length; $i++) {
            $field = $this->results[$i]->getFieldByKey($key);
            if (!isset($field)) break;

            if ($field->getValue() < $value) {
                array_splice($this->results, $i, 1);
                $this->length--;
                $i--;
            }
        }
        return $this;
    }

    public function smaller($key, $value)
    {
        for ($i = 0; $i < $this->length; $i++) {
            $field = $this->results[$i]->getFieldByKey($key);
            if (!isset($field)) break;

            if ($field->getValue() > $value) {
                array_splice($this->results, $i, 1);
                $this->length--;
                $i--;
            }
        }
        return $this;
    }

    public function equals($key, $value)
    {
        for ($i = 0; $i < $this->length; $i++) {
            $field = $this->results[$i]->getFieldByKey($key);
            if (!isset($field)) break;
            $oriValue = $field->getValue();

            if ($field->getType() === Property::FIELD_INT) {
                $value = intval($value);
                $oriValue = intval($oriValue);
            }
            if ($field->getType() === Property::FIELD_DECIMAL) {
                $value = floatval($value);
                $oriValue = floatval($oriValue);
            }
            if ($field->getType() === Property::FIELD_BOOLEAN) {
                if ($value === 1 || $value === true || $value === "1") {
                    $value = 1;
                }
                if ($value === 0 || $value === false || $value === "0") {
                    $value = 0;
                    $oriValue = floatval($oriValue);
                }
                $oriValue = intval($oriValue);
            }

            if ($oriValue !== $value) {
                array_splice($this->results, $i, 1);
                $this->length--;
                $i--;
            }
        }
        return $this;
    }

    public function contains($key, $value)
    {
        for ($i = 0; $i < $this->length; $i++) {
            $field = $this->results[$i]->getFieldByKey($key);
            if (!isset($field)) break;
            if (strripos($field->getValue(), $value) === false) {
                array_splice($this->results, $i, 1);
                $this->length--;
                $i--;
            }
        }
        return $this;
    }

    public function deleteAll()
    {
        foreach ($this->results as $result) {
            $result->delete();
        }
    }

    public static function showTable(ResultSet $resultSet)
    {
        if ($resultSet->length === 0) return "";
        $table = "<table border='1' style='border-collapse: collapse;'>";
        $fields = $resultSet->first()->getFieldsAccess();
        $table .= "<thead><tr>";
        foreach ($fields as $field) {
            $table .= "<th>" . $field->getKey() . "</th>";
        }
        $table .= "</tr></thead>";
        foreach ($resultSet->results as $result) {
            $table .= "<tr>";
            foreach ($result->getFieldsAccess() as $fieldsAccess) {
                $table .= "<td><span>".$fieldsAccess->getValue()."</span></td>";
            }
            $table .= "</tr>";
        }
        $table .= "</table>";
        echo $table;
    }

    private function isEmpty()
    {
        return $this->length === 0;
    }

}