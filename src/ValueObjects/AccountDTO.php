<?php

namespace SamuelMwangiW\Africastalking\ValueObjects;

use SamuelMwangiW\Africastalking\Contracts\DTOContract;

class AccountDTO implements DTOContract
{
    public function __construct(
        public float $balance,
        public string $currency,
    ){}

    public function __toString(): string
    {
        return "{$this->currency} {$this->balance}";
    }

    public function __toArray(): array
    {
        return [
            'amount' => $this->balance,
            'curency' => $this->currency,
            'balance' => "{$this->currency} {$this->balance}",
        ];
    }
}
