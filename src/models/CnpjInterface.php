<?php

namespace App\models;

interface CnpjInterface
{
    public function isValid(): bool;

    public function format(): string;

    public function generate(): string;

    public function mask(): string;

    protected function setCnpj(): Void;
}