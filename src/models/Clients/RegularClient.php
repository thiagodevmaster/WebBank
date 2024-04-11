<?php

namespace App\models\Clients;
use App\models\CPF;
use App\models\Passwords\PasswordInterface;

class RegularClient extends Client
{
    public function __construct(
        string $name, 
        string $email, 
        PasswordInterface $password, 
        ?CPF $cpf = null, 
        bool $status = true
    )
    {
        parent::__construct($name, "r", $email, $password, $cpf, null, $status);
    }

    final public function canTransfer(): bool
    {
        return true;
    }
}