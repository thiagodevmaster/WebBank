<?php

namespace App\models\Exceptions;
use Exception;
use Throwable;

class InvalidPasswordException extends Exception
{
    public function __construct(string $message = 'Senha informada inválida.', int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}