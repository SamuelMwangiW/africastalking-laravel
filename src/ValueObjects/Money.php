<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects;

use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\Enum\Currency;

class Money implements DTOContract
{
    public function __construct(
        public readonly float $amount,
        public readonly Currency $currency,
    ) {}

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

    public static function make(string $value): Money
    {
        $parts = explode(' ', $value);

        return new Money(
            amount: floatval($parts[1]),
            currency: Currency::from($parts[0]),
        );
    }
}
