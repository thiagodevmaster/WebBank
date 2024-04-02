<?php

namespace App\models;

class Decimal
{
    public function __construct(private int $value)
    {}

    public function getValue(): int
    {
        return $this->value;
    }

    public function add(Decimal $decimal): Decimal
    {
        return new Decimal($this->value + $decimal->getValue());
    }

    public function subtract(Decimal $decimal): Decimal
    {
        return new Decimal($this->value - $decimal->getValue());
    }

    public function multiply(Decimal $decimal): Decimal
    {
        return new Decimal($this->value * $decimal->getValue());
    }

    public function divide(Decimal $decimal): Decimal
    {
        if ($decimal->getValue() == 0) {
            throw new \InvalidArgumentException("Não é possivel dividir por zero.");
        }

        return new Decimal($this->value / $decimal->getValue());
    }
}