<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 03/12/2016
 * Time: 7:57
 */

namespace FrameworkIvan\Database;

use FrameworkIvan\Model\Table;


interface Database
{

    function connect();

    function disconnect();

    function status();

    function execute($query);

    function createTable(Table $structure);

    function dropTable(Table $structure);

    function insert(Table $structure);

    function update(Table $origin, Table $destiny);

    function delete(Table $structure);

    function all(Table $structure);

    function where(Table $structure, $key, $value, $operator);

}
