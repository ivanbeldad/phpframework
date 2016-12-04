<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 03/12/2016
 * Time: 19:08
 */

namespace Akimah\Database;


class DatabaseFactory
{

    const MYSQL = "mysql";

    static public function getDatabase()
    {
        $string = "";
        $file = fopen(DatabaseFactory::getConfigPath(), "r");
        while (!feof($file)) {
            $string .= fgets($file);
        }
        $databaseType = json_decode($string, true)["database_configuration"]["type"];
        switch ($databaseType) {
            case DatabaseFactory::MYSQL:
                return new MysqlDatabase();
            default:
                return new MysqlDatabase();
        }
    }

    static function getConfigPath()
    {
        $var = new \ReflectionClass(DatabaseFactory::class);
        $path = str_replace("\\". $var->getShortName() .".php", "", $var->getFileName());
        $path .= "\\db_conf.json";
        return $path;
    }

}