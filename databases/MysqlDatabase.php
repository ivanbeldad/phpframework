<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 03/12/2016
 * Time: 7:55
 */

namespace FrameworkIvan\Database;

use FrameworkIvan\Model\Result;
use FrameworkIvan\Model\ResultSet;
use FrameworkIvan\Model\Table;
use FrameworkIvan\Model\Property;
use FrameworkIvan\Model\ForeignKey;


class MysqlDatabase implements Database
{

    private $link;
    private $host;
    private $user;
    private $password;
    private $database;
    private $port;

    public function __construct($host, $user, $password, $database, $port = 3306)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->port = $port;
        mysqli_report(MYSQLI_REPORT_STRICT);
    }

    public function connect()
    {
        if ($this->host === "") throw new Exception("");

        if (!isset($this->link)) {
            $this->link = mysqli_connect(
                $this->host,
                $this->user,
                $this->password,
                $this->database,
                $this->port
            );
            mysqli_set_charset($this->link, "utf8");
        }
    }

    public function disconnect()
    {
        mysqli_close($this->link);
        unset($this->link);
    }

    public function status()
    {
        $this->host;
        $this->user;
        $this->password;
        $this->database;
        $this->port;
        if (isset($this->link)) return true;
        return false;
    }

    public function execute($query)
    {
        $this->connect();
        if (!$this->status()) return false;
        $result = mysqli_query($this->link, $query);
        if (mysqli_error($this->link)) {
            $result = mysqli_error($this->link);
        }
        $this->disconnect();
        return $result;
    }

    // CREATE AND DROP TABLE

    public function createTable(Table $structure)
    {
        $this->createFields($structure);
        $this->addIndexes($structure);
        $this->addForeignKeys($structure);
    }

    public function dropTable(Table $structure)
    {
        $tableName = $structure->getTableName();
        $query = "DROP TABLE $tableName";
        return $this->execute($query);
    }

    // INSERT UPDATE AND DELETE RECORDS

    public function insert(Table $structure)
    {
        $tableName = $structure->getTableName();
        if ($structure->invalidInsertRequirements()) return false;
        $keys = $structure->getSettedKeys();
        $keys = join(",", $keys);
        $values = $structure->getProperties();
        foreach ($values as $value) {
            if ($value->isValue()) {
                $value->setValue($this->getValueFormatted($value));
            }
        }
        $values = join(",", $structure->getSettedValues());
        $query = "INSERT INTO " . $tableName . " ($keys) VALUES ($values)";
        return $this->execute($query);
    }

    public function update(Table $origin, Table $destiny)
    {
        $tableName = $origin->getTableName();
        if ($destiny->invalidInsertRequirements()) return false;

        $destinyString = $this->setValuesString($destiny);
        $originString = $this->conditions($origin);

        $query = "UPDATE $tableName SET ";
        $query .= $destinyString;
        $query .= " WHERE ";
        $query .= $originString;

        return $this->execute($query);
    }

    public function delete(Table $structure)
    {
        $tableName = $structure->getTableName();
        $conditions = $this->conditions($structure);
        $query = "DELETE FROM $tableName WHERE $conditions";
        return $this->execute($query);
    }

    public function all(Table $structure)
    {
        $tableName = $structure->getTableName();
        $query = "SELECT * FROM $tableName";
        $result = $this->execute($query);
        $resultSet = new ResultSet();
        while ($row = mysqli_fetch_assoc($result)) {
            $resultSet->addResult(Result::assocArrayToResult($structure, $row));
        }
        return $resultSet;
    }

    // PRIVATE USAGE

    private function createFields(Table $structure)
    {
        $table = $structure->getTableName();
        $properties = $structure->getProperties();
        $propertiesStrings = [];
        foreach ($properties as $property) {
            $key = $property->getKey();
            $type = $this->getTypeString($property->getType());
            $size = $property->isSize() ? "(" . $property->getSize() . ")" : "";
            $nullable = $property->isNullable() ? "" : "NOT NULL";
            $unique = $property->isUnique() ? "UNIQUE" : "";
            $primaryKey = $property->isPrimaryKey() ? "PRIMARY KEY" : "";
            $autoIncrement = $property->isAutoIncrement() ? "AUTO_INCREMENT" : "";
            $defaultValue = $property->isDefaultValue() ? "DEFAULT " . $this->getDefaultValueFormatted($property) : "";
            $string = "$key $type $size $nullable $unique $defaultValue $primaryKey $autoIncrement";
            array_push($propertiesStrings, $string);
        }
        $propertiesStrings = join(" , ", $propertiesStrings);
        $query = "CREATE TABLE $table ($propertiesStrings)";
        $this->execute($query);
    }

    private function addForeignKeys(Table $structure)
    {
        $table = $structure->getTableName();
        $properties = $structure->getProperties();
        foreach ($properties as $property) {
            if ($property->isForeignKey()) {
                $foreignKey = $property->getForeignKey();
                $constraint = $foreignKey->getConstraint();
                $keyFrom = $foreignKey->getKeyFrom();
                $keyTo = $foreignKey->getKeyTo();
                $references = $foreignKey->getReferenceTable();
                $query = "ALTER TABLE $table ADD CONSTRAINT $constraint FOREIGN KEY ($keyFrom) REFERENCES $references($keyTo)";
                $query .= " ON UPDATE " . $this->getActionFormatted($foreignKey->getOnUpdate());
                $query .= " ON DELETE " . $this->getActionFormatted($foreignKey->getOnDelete());
                $this->execute($query);
            }
        }
    }

    private function addIndexes(Table $structure)
    {
        $table = $structure->getTableName();
        $properties = $structure->getProperties();
        foreach ($properties as $property) {
            if ($property->isIndex()) {
                $key = $property->getKey();
                $query = "ALTER TABLE $table ADD INDEX ($key)";
                $this->execute($query);
            }
        }
    }

    private function setValuesString(Table $structure)
    {
        $structureString = [];
        $structureKeys = $structure->getSettedKeys();
        $structureValues = $structure->getSettedValues();
        $structureNum = count($structureKeys);
        for ($i = 0; $i < $structureNum; $i++) {
            array_push($structureString, $structureKeys[$i] . "=" . $structureValues[$i]);
        }
        $structureString = join(" , ", $structureString);
        return $structureString;
    }

    private function conditions(Table $structure)
    {
        // WHERE
        $structureString = [];
        $structureKeys = $structure->getSettedKeys();
        $structureValues = $structure->getSettedValues();
        $structureNum = count($structureKeys);
        for ($i = 0; $i < $structureNum; $i++) {
            array_push($structureString, $structureKeys[$i] . "=" . $structureValues[$i]);
        }
        $structureString = join(" AND ", $structureString);
        return $structureString;
    }

    private function getTypeString($type)
    {
        switch ($type) {
            case Property::FIELD_STRING:
                return "VARCHAR";
            case Property::FIELD_EMAIL:
                return "VARCHAR";
            case Property::FIELD_DATE:
                return "DATE";
            case Property::FIELD_TIME:
                return "TIME";
            case Property::FIELD_DATETIME:
                return "DATETIME";
            case Property::FIELD_DECIMAL:
                return "DECIMAL";
            case Property::FIELD_INT:
                return "INT";
            case Property::FIELD_BOOLEAN:
                return "BINARY";
            default:
                return "VARCHAR";
        }
    }

    private function getValueFormatted(Property $property)
    {
        $value = $property->getValue();
        if ($property->getType() === Property::FIELD_INT) $value = intval($value);
        else if ($property->getType() === Property::FIELD_DECIMAL) $value = floatval($value);
        else if ($property->getType() === Property::FIELD_BOOLEAN) $value = intval($value);
        else $value = "'" . $value . "'";
        return $value;
    }

    private function getDefaultValueFormatted(Property $property)
    {
        $value = $property->getDefaultValue();
        if ($property->getType() === Property::FIELD_INT) $value = intval($value);
        else if ($property->getType() === Property::FIELD_DECIMAL) $value = floatval($value);
        else if ($property->getType() === Property::FIELD_BOOLEAN) $value = intval($value);
        else $value = "'" . $value . "'";
        return $value;
    }

    private function getActionFormatted($action)
    {
        switch ($action) {
            case ForeignKey::ACTION_RESTRICT:
                return "RESTRICT";
            case ForeignKey::ACTION_CASCADE:
                return "CASCADE";
            case ForeignKey::ACTION_NO_ACTION:
                return "NO ACTION";
            case ForeignKey::ACTION_SET_NULL:
                return "SET NULL";
            default:
                "RESTRICT";
        }
    }

}