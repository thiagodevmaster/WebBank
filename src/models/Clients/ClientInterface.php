<?php

namespace App\models\Client;
use App\models\Account\AccountInterface;

interface ClientInterface
{
    public function getClientId(): int;

    public function setId(int $id): void;

    public function getName(): string;

    public function getType(): string;

    public function getAccounts(): array;

    public function addAccount(AccountInterface $account): void;

    public function removeAccount(AccountInterface $account): void;

    public function canTransfer(): bool;
}