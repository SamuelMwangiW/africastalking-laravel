<?php

namespace SamuelMwangiW\Africastalking\Factories;

use Illuminate\Support\Str;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\ValueObjects\Balance;

class AccountFactory implements \SamuelMwangiW\Africastalking\Contracts\FactoryContract
{
    public static function make(array $data): Balance
    {
        $balance = Str::of(data_get($data, 'UserData.balance'));
        $currencyCode = $balance->before(' ')->toString();

        return new Balance(
            amount: floatval($balance->after(' ')->toString()),
            currency: Currency::tryFrom($currencyCode) ?? Currency::INTERNATIONAL,
        );
    }
}
