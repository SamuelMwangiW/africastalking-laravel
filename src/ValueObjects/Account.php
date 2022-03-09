<?php

namespace SamuelMwangiW\Africastalking\ValueObjects;

use SamuelMwangiW\Africastalking\Contracts\DTOContract;

class Account implements DTOContract
{
    public function __construct(
        public float $balance,
        public string $currency,
    ) {
    }

    public static function make(float $balance, string $currency): Account
    {
        return new Account(
            balance: $balance,
            currency: $currency,
        );
    }

    public function __toString(): string
    {
        return "{$this->currency} {$this->balance}";
    }

    public function __toArray(): array
    {
        return [
            'amount' => $this->balance,
            'currency' => $this->currency,
            'balance' => "{$this->currency} {$this->balance}",
        ];
    }
}
