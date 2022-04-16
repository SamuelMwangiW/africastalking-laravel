<?php

namespace SamuelMwangiW\Africastalking\ValueObjects;

use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\Enum\Currency;

class Account implements DTOContract
{
    public function __construct(
        public float $balance,
        public Currency $currency,
    ) {
    }

    public static function make(float $balance, Currency $currency): Account
    {
        return new Account(
            balance: $balance,
            currency: $currency,
        );
    }

    public function __toString(): string
    {
        return "{$this->currency->value} {$this->balance}";
    }

    public function __toArray(): array
    {
        return [
            'amount' => $this->balance,
            'currency' => $this->currency->value,
            'balance' => "{$this->currency->value} {$this->balance}",
        ];
    }
}
