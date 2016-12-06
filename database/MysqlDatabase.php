<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 03/12/2016
 * Time: 7:55
 */

namespace Akimah\Database;
use Akimah\Model\Result;
use Akimah\Model\ResultSet;
use Akimah\Model\AccessTable;
use Akimah\Model\AccessProperty;


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

    public function status() {
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

    public function createTable(AccessTable $structure)
    {
        $tableName = $structure->getTableName();
        $fields = $structure->getAccessProperties();
        $query = "CREATE TABLE $tableName (";
        $stringFields = [];
        foreach ($fields as $field) {
            array_push($stringFields, $this->createTableField($field));
        }
        $stringFields = join(" , ", $stringFields);
        $query .= $stringFields;
        $query .= ");";
        return $this->execute($query);
    }

    public function dropTable(AccessTable $structure)
    {
        $tableName = $structure->getTableName();
        $query = "DROP TABLE $tableName";
        return $this->execute($query);
    }

    // INSERT UPDATE AND DELETE RECORDS

    public function insert(AccessTable $structure) {
        $tableName = $structure->getTableName();
        if ($structure->invalidInsertRequirements()) return false;
        $keys = $structure->getSettedKeys();
        $keys = join(",", $keys);
        $values = $structure->getSettedValues();
        $values = join(",", $values);
        $query = "INSERT INTO " . $tableName . " ($keys) VALUES ($values)";
        return $this->execute($query);
    }

    public function update(AccessTable $origin, AccessTable $destiny)
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

    public function delete(AccessTable $structure)
    {
        $tableName = $structure->getTableName();
        $conditions = $this->conditions($structure);
        $query = "DELETE FROM $tableName WHERE $conditions";
        return $this->execute($query);
    }

    public function all(AccessTable $structure)
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

    private function setValuesString(AccessTable $structure)
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

    private function conditions(AccessTable $structure)
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

    private function createTableField(AccessProperty $field)
    {
        $string = "";
        $string .= $field->getKey() . " ";
        $string .= $field->getType() . $field->getSizeString() . " ";
        $string .= $field->isAutoIncrementString() . " ";
        $string .= $field->isPrimaryKeyString() . " ";
        $string .= $field->isNullableString() . " ";
        $string .= $field->getDefaultValueString() . " ";
        return $string;
    }

}