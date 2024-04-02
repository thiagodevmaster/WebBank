<?php

namespace App\models\Account;
use App\models\Decimal;

class Account implements AccountInterface
{
    private ?int $id;

    public function __construct(

        private Decimal $balance = 0.0
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

    }

    public function getAccountId(): int
    {

    }

    public function getClient(): Client
    {

    }

    public function closeAccount(): bool
    {

    }

    public function updateBalance(Decimal $newBalance): bool
    {

    }

    public function canTransfer(): bool
    {

    }
}