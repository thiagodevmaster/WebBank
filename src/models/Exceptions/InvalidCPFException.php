<?php

namespace App\models\Exceptions;

use Exception;
use Throwable;

class InvalidCPFException extends Exception {
    public function __construct(string $message = 'CPF inválido.', int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

