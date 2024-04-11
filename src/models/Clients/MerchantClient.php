<?php

namespace App\models\Clients;
use App\models\Cnpj;
use App\models\Passwords\PasswordInterface;

class MerchantClient extends Client
{
    public function __construct(
        string $name,
        string $email,
        PasswordInterface $password,
        Cnpj $cnpj,
        bool $status = true
    )
    {
        parent::__construct($name, 'm', $email, $password, null, $cnpj, $status);
    }

    public function canTransfer(): bool
    {
        return false;
    }
}
