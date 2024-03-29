<?php

namespace App\models\Client;

interface ClientInterface
{
    public function getClientId(): int;

    public function getName(): string;

    public function getType(): string;

    public function getAccounts(): array;

    public function addAccount(Account $account): void;

    public function removeAccount(Account $account): void;

    public function canTransfer(): bool;
}