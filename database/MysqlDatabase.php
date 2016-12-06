<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 03/12/2016
 * Time: 7:55
 */

namespace Akimah\Database;
use Akimah\Model\Result;
use Akimah\Model\ResultSet;
use Akimah\Model\Table;
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

    public function __construct()
    {
        $this->configurate();
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
        $fields = $structure->getFieldsAccess();
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
        $keys = $structure->getAllSettedNames();
        $keys = join(",", $keys);
        $values = $structure->getAllSettedValues();
        $values = join(",", $values);
        $query = "INSERT INTO " . $tableName . " ($keys) VALUES ($values)";
        return $this->execute($query);
    }

    public function all(AccessTable $structure)
    {
        $tableName = $structure->getTableName();
        $query = "SELECT * FROM $tableName";
        $result = $this->execute($query);
        $resultSet = new ResultSet();
        while ($row = mysqli_fetch_assoc($result)) {
            $resultSet->addResult(Result::rowToResult($structure, $row));
        }
        return $resultSet;
    }

    // PRIVATE USAGE

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

    private function configurate()
    {
        $string = "";
        $file = fopen(DatabaseFactory::getConfigPath(), "r") or die("MUEREEE!");
        while (!feof($file)) {
            $string .= fgets($file);
        }
        $config = json_decode($string, true)["database_configuration"];
        $this->host = $config["host"];
        $this->user = $config["user"];
        $this->password = $config["password"];
        $this->database = $config["database"];
        $this->port = $config["port"];
    }

}