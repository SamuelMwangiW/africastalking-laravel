<?php

namespace SamuelMwangiW\Africastalking\Factories;

use Illuminate\Support\Str;
use SamuelMwangiW\Africastalking\ValueObjects\AccountDTO;

class AccountFactory implements \SamuelMwangiW\Africastalking\Contracts\FactoryContract
{
    public static function make(array $data): AccountDTO
    {
        $balance = Str::of(data_get($data, 'UserData.balance'));

        return new AccountDTO(
            balance: floatval($balance->after(' ')->toString()),
            currency: $balance->before(' ')->toString(),
        );
    }
}
