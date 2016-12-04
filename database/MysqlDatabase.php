<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 03/12/2016
 * Time: 7:55
 */

namespace Akimah\Database;
use Akimah\Model\Table;
use Akimah\Model\TableAccess;
use Akimah\Model\TableFieldAccess;


class MysqlDatabase implements Database
{

    private $link;
    private $host;
    private $user;
    private $password;
    private $database;
    private $port;

    function __construct()
    {
        $this->configurate();
        mysqli_report(MYSQLI_REPORT_STRICT);
    }

    function connect()
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

    function disconnect()
    {
        mysqli_close($this->link);
        unset($this->link);
    }

    function status() {
        $this->host;
        $this->user;
        $this->password;
        $this->database;
        $this->port;
        if (isset($this->link)) return true;
        return false;
    }

    function execute($query)
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

    function createTable($name, TableAccess $structure)
    {
        $fields = $structure->getTableFields();
        $query = "CREATE TABLE $name (";
        $stringFields = [];
        foreach ($fields as $field) {
            array_push($stringFields, $this->createTableField($field));
        }
        $stringFields = join(" , ", $stringFields);
        $query .= $stringFields;
        $query .= ");";
        echo $query;
        return $this->execute($query);
    }

    private function createTableField(TableFieldAccess $field)
    {
        $string = "";
        $string .= $field->getName() . " ";
        $string .= $field->getType() . "(" . $field->getSize() . ") ";
        $string .= $field->isAutoIncrement() . " ";
        $string .= $field->isPrimaryKey() . " ";
        $string .= $field->isNullable() . " ";
        return $string;
    }

    function dropTable($name)
    {
        $query = "DROP TABLE $name";
        return $this->execute($query);
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