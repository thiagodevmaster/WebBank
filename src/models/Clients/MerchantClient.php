<?php

namespace App\models\Clients;
use App\models\{CpfInterface, CnpjInterface};
use App\models\Passwords\PasswordInterface;

class MerchantClient extends Client
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
        parent::__construct($name, 'merchant', $email, $password, $cpf, $cnpj, $status);
    }

    public function canTransfer(): bool
    {
        return false;
    }
}
