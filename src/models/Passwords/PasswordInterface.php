<?php

namespace App\models\Passwords;
use App\models\Clients\Client;

interface PasswordInterface
{
    public function validatePassword(string $password): bool;

    public function hash(string $password): string;

    public function verify(string $password, string $hashadPassword): bool;

    public function resetPassword(Client $client, string $newPassword): bool;

    public function getValue(): string;
}