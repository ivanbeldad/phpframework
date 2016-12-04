<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 03/12/2016
 * Time: 7:57
 */

namespace Akimah\Database;


interface Database
{

    function connect();

    function disconnect();

    function status();

    function execute($query);

}