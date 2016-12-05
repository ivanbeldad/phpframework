<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 03/12/2016
 * Time: 7:55
 */

namespace Akimah\Database;
use Akimah\Model\Table;
use Akimah\Model\TableAccess;
use Akimah\Model\FieldAccess;


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

    public function createTable(TableAccess $structure)
    {
        $tableName = $structure->getTableName();
        $fields = $structure->getTableFields();
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

    public function dropTable(TableAccess $structure)
    {
        $tableName = $structure->getTableName();
        $query = "DROP TABLE $tableName";
        return $this->execute($query);
    }

    public function insert(TableAccess $structure) {
        $tableName = $structure->getTableName();
        if ($structure->invalidInsertRequirements()) return false;
        $keys = $structure->getAllSettedNames();
        $keys = join(",", $keys);
        $values = $structure->getAllSettedValues();
        $values = join(",", $values);
        $query = "INSERT INTO " . $tableName . " ($keys) VALUES ($values)";
        return DatabaseFactory::getDatabase()->execute($query);
    }

    private function createTableField(FieldAccess $field)
    {
        $string = "";
        $string .= $field->getName() . " ";
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