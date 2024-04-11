<?php

namespace App\models\Clients;
use App\models\Account\AccountInterface;

interface ClientInterface
{
    public function getClientId(): ?int;

    public function setId(int $id): void;

    public function getName(): string;

    public function getType(): string;

    public function getAccounts(): array;

    public function addAccount(AccountInterface $account): void;

    public function removeAccount(AccountInterface $account): void;

    public function getDocument(): string;

    public function canTransfer(): bool;

    public function getEmail(): string;

    public function getPassword(): string;
}