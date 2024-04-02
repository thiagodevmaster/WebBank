<?php

namespace App\models\Account;

class Account implements AccountInterface
{
    private ?int $id;

    public function __construct(
        private Decimal $balance = 0.0,

    )
    {}

    public function getBalance(): Decimal
    {

    }

    public function deposit(Decimal $amount): void
    {

    }

    public function withdraw(Decimal $amount): void
    {

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