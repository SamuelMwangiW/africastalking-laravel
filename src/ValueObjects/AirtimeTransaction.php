<?php

namespace SamuelMwangiW\Africastalking\ValueObjects;

use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\Enum\Currency;

class AirtimeTransaction implements DTOContract
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

    public function __toArray(): array
    {
        return [
            "phoneNumber" => $this->phoneNumber->number,
            "amount" => "{$this->currencyCode->value} {$this->amount}",
        ];
    }
}
