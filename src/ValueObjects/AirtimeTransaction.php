<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\Enum\Currency;

/**
 * @implements Arrayable<string, string>
 */
class AirtimeTransaction implements DTOContract, Arrayable
{
    public function __construct(
        public PhoneNumber $phoneNumber,
        public Currency    $currencyCode,
        public int         $amount,
    ) {
    }

    public static function make(string $phoneNumber, Currency $currency, int $amount): AirtimeTransaction
    {
        return new AirtimeTransaction(
            phoneNumber: PhoneNumber::make($phoneNumber),
            currencyCode: $currency,
            amount: $amount,
        );
    }

    public function __toString(): string
    {
        return strval(
            json_encode($this->__toArray())
        );
    }

    public function toArray(): array
    {
        return [
            "phoneNumber" => $this->phoneNumber->number,
            "amount" => "{$this->currencyCode->value} {$this->amount}",
        ];
    }

    public function __toArray(): array
    {
        return $this->toArray();
    }
}
