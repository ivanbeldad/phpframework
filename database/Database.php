<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 03/12/2016
 * Time: 7:57
 */

namespace Akimah\Database;
use Akimah\Model\Table;
use Akimah\Model\TableAccess;


interface Database
{

    function connect();

    function disconnect();

    function status();

    function execute($query);

    function createTable(TableAccess $structure);

    function dropTable(TableAccess $structure);

    function insert(TableAccess $structure);

//    function update($structure);

//    function delete($structure);

}