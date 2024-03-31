<?php

namespace App\models;

interface CpfInterface
{
    public function isValid(): bool;

    public function format(): string;

    public function generate(): string;

    public function mask(): string;

    protected function setCpf(): Void;

}