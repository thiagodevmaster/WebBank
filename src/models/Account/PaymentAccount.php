<?php

namespace App\models\Account;
use App\models\Client\ClientInterface;

class PaymentAccount extends Account
{
    public function __construct(
        private ClientInterface $client,
    )
    {
        parent::__construct($client);
    }

    
}