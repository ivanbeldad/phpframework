<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 03/12/2016
 * Time: 7:57
 */

namespace Akimah\Database;
use Akimah\Model\Table;
use Akimah\Model\AccessTable;


interface Database
{

    function connect();

    function disconnect();

    function status();

    function execute($query);

    function createTable(AccessTable $structure);

    function dropTable(AccessTable $structure);

    function insert(AccessTable $structure);

    function update(AccessTable $origin, AccessTable $destiny);

    function delete(AccessTable $structure);

    function all(AccessTable $structure);

}