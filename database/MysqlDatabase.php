<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 03/12/2016
 * Time: 7:55
 */

namespace Akimah\Database;


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
        if (!$this->status()) return false;
        return mysqli_query($this->link, $query);
    }

    private function configurate()
    {
        $string = "";
        $file = fopen(DatabaseController::getConfigPath(), "r") or die("MUEREEE!");
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
