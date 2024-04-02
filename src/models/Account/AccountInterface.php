<?php

namespace App\models\Account;
use App\models\Client\ClientInterface;
use App\models\Decimal;

interface AccountInterface
{
    public function getId(): int;

    public function getBalance(): Decimal;

    public function deposit(Decimal $amount): void;

    public function withdraw(Decimal $amount): void;

    public function getTransactions(): array;

    public function getAccountId(): int;

    public function getClient(): ClientInterface;

    public function closeAccount(): void;

    public function updateBalance(Decimal $newBalance): bool;

}