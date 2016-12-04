<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 03/12/2016
 * Time: 19:08
 */

namespace Akimah\Database;


class DatabaseController
{

    const MYSQL = "mysql";

    /**
     * @var Database
     */
    private $database;

    function __construct()
    {
        $this->database = $this->selectDatabase();
    }

//    private function selectDatabase()
//    {
//        $string = "";
//        $file = fopen(DatabaseController::getConfigPath(), "r");
//        while (!feof($file)) {
//            $string .= fgets($file);
//        }
//        $databaseType = json_decode($string, true)["database_configuration"]["type"];
//        switch ($databaseType) {
//            case DatabaseController::MYSQL:
//                return new MysqlDatabase();
//            default:
//                return new MysqlDatabase();
//        }
//    }

    static private function selectDatabase()
    {
        $string = "";
        $file = fopen(DatabaseController::getConfigPath(), "r");
        while (!feof($file)) {
            $string .= fgets($file);
        }
        $databaseType = json_decode($string, true)["database_configuration"]["type"];
        switch ($databaseType) {
            case DatabaseController::MYSQL:
                return new MysqlDatabase();
            default:
                return new MysqlDatabase();
        }
    }

//    function execute($query)
//    {
//        $this->database->connect();
//        $result = $this->database->execute($query);
//        $this->database->disconnect();
//        return $result;
//    }

    static function execute($query)
    {
        $database = DatabaseController::selectDatabase();
        $database->connect();
        $result = $database->execute($query);
        $database->disconnect();
        return $result;
    }

    static function getConfigPath()
    {
        $var = new \ReflectionClass(DatabaseController::class);
        $path = str_replace("\\". $var->getShortName() .".php", "", $var->getFileName());
        $path .= "\\db_conf.json";
        return $path;
    }

}