<?php

namespace App\Exceptions;

use Exception;

class NullVariableException extends Exception
{
    public function __construct($message = "A variável é nula.")
    {
        parent::__construct($message);
    }
}
