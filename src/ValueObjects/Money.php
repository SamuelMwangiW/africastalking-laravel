<?php

namespace SamuelMwangiW\Africastalking\ValueObjects;

use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\Enum\Currency;

class Money implements DTOContract
{

    public function __construct(
        public readonly float $amount,
        public readonly Currency $currency,
    )
    {
    }

    public function __toString(): string
    {
        return "{$this->currency->value} {$this->amount}";
    }

    public function __toArray(): array
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency,
        ];
    }
}
