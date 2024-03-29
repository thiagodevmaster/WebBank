<?php

namespace App\models\Transaction;

interface TransactionInterface
{
    public function getTansactionId(): int;

    public function getAmount(): Decimal;

    public function getType(): string;

    public function getSourceAccount(): Account;

    public function getDestinationAccount(): Account;

    public function getDate(): Datetime;
}