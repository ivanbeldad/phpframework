<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 06/12/2016
 * Time: 6:54
 */

namespace FrameworkIvan\Exception;

use Exception;


class EmptyResultsException extends Exception
{
    public function __construct()
    {
        $this->message = "There are not any results.";
    }
}