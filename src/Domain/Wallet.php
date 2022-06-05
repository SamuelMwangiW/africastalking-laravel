<?php

namespace SamuelMwangiW\Africastalking\Domain;

use Illuminate\Support\Str;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\Transporter\Requests\Payment\WalletBalanceRequest;
use SamuelMwangiW\Africastalking\ValueObjects\Balance;

class Wallet
{
    /**
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \Exception
     */
    public function balance(): Balance
    {
        $response = WalletBalanceRequest::build()->fetch();

        if (data_get($response, 'status') !== 'Success') {
            throw new \Exception('Failed to fetch wallet balance');
        }

        $balance = Str::of($response['balance'])->after(' ')->toString();
        $currency = Str::of($response['balance'])->before(' ')->toString();

        return Balance::make(
            balance: floatval($balance),
            currency: Currency::from($currency),
        );
    }
}
