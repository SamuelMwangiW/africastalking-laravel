<?php

namespace SamuelMwangiW\Africastalking\ValueObjects;

use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\Enum\Currency;

class Balance implements DTOContract
{
    public function __construct(
        public float    $amount,
        public Currency $currency,
    ) {
    }

    public static function make(float $balance, Currency $currency): Balance
    {
        return new Balance(
            amount: $balance,
            currency: $currency,
        );
    }

    public function __toString(): string
    {
        return "{$this->currency->value} {$this->amount}";
    }

    public function __toArray(): array
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency->value,
            'balance' => "{$this->currency->value} {$this->amount}",
        ];
    }
}
