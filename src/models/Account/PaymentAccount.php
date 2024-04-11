<?php

namespace App\models\Account;
use App\models\Client\ClientInterface;
use App\models\Clients\Client;

class PaymentAccount extends Account
{
    public function __construct(
        private Client $client,
    )
    {
        parent::__construct($client);
    }

    
}