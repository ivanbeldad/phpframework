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
        $configuration = self::getConfiguration();
        switch ($configuration["type"]) {
            case DatabaseFactory::MYSQL:
                return new MysqlDatabase(
                    $configuration["host"],
                    $configuration["user"],
                    $configuration["password"],
                    $configuration["database"],
                    $configuration["port"]
                );
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

    private static function getConfiguration()
    {
        $string = "";
        $file = fopen(DatabaseFactory::getConfigPath(), "r") or die("MUEREEE!");
        while (!feof($file)) {
            $string .= fgets($file);
        }
        $config = json_decode($string, true);
        $configuration = [
            "host" => $config["host"],
            "user" => $config["user"],
            "password" => $config["password"],
            "database" => $config["database"],
            "port" => $config["port"],
            "type" => $config["type"]
        ];
        return $configuration;
    }

}