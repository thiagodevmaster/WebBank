<?php

namespace App\models\Account;
use App\models\Client\ClientInterface;
use App\models\Clients\Client;
use App\models\Decimal;

class Account implements AccountInterface
{
    private ?int $id;
    protected array $transactions = [];

    public function __construct(
        private Client $client,
        private Decimal $balance = 0,
        private bool $status = true
    )
    {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getBalance(): Decimal
    {
        return $this->balance;
    }

    public function deposit(Decimal $amount): void
    {
        $this->balance = $this->balance->add($amount);
    }

    public function withdraw(Decimal $amount): void
    {
        $this->balance = $this->balance->subtract($amount);
    }


    public function getTransactions(): array
    {
        return $this->transactions;
    }

    public function getAccountId(): int
    {
        return $this->id;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function closeAccount(): void
    {
        $this->status = false;
    }

    public function updateBalance(Decimal $newBalance): bool
    {
        $this->balance = $newBalance;

        return true;
    }

}