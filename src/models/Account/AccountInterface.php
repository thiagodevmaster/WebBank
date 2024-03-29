<?php

namespace App\models\Account;

interface AccountInterface
{
    public function getBalance(): Decimal;

    public function deposit(Decimal $amount): void;

    public function withdraw(Decimal $amount): void;

    public function getTransactions(): array;

    public function getAccountId(): int;

    public function getClient(): Client;

    public function closeAccount(): bool;

    public function updateBalance(Decimal $newBalance): bool;

    public function canTransfer(): bool;
}