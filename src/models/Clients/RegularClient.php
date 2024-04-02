<?php

namespace App\models\Clients;
use App\models\{CpfInterface, CnpjInterface};
use App\models\Passwords\PasswordInterface;

class RegularClient extends Client
{
    public function __construct(
        string $name, 
        string $email, 
        PasswordInterface $password, 
        ?CpfInterface $cpf = null, 
        ?CnpjInterface $cnpj = null, 
        bool $status = true
    )
    {
        parent::__construct($name, "regular", $email, $password, $cpf, $cnpj, $status);
    }

    final public function canTransfer(): bool
    {
        return true;
    }
}