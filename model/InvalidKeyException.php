<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 06/12/2016
 * Time: 6:56
 */

namespace Akimah\Model;
use Exception;

class InvalidKeyException extends Exception
{
    public function __construct()
    {
        $this->message = "Invalid key.";
    }
}