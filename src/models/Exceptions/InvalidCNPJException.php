<?php

namespace App\models\Exceptions;

use Exception;

class InvalidCNPJException extends Exception
{
    public function __construct(string $message = "CNPJ inválido", int $code = 0, \Throwable $previous = null){
        parent::__construct($message, $code, $previous);
    }
}