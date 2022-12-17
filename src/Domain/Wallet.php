<?php

namespace SamuelMwangiW\Africastalking\Domain;

use Illuminate\Support\Str;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\Saloon\Requests\Payment\WalletBalanceRequest;
use SamuelMwangiW\Africastalking\ValueObjects\Balance;

class Wallet
{
    /**
     * @return Balance
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     * @throws \Sammyjo20\Saloon\Exceptions\SaloonException
     * @throws \Sammyjo20\Saloon\Exceptions\SaloonRequestException
     * @throws \Exception
     */
    public function balance(): Balance
    {
        $request = new WalletBalanceRequest();
        $response = $request->send()->throw();

        if ($response->json('status') !== 'Success') {
            throw new \Exception('Failed to fetch wallet balance');
        }

        $balance = Str::of($response->json('balance'))->after(' ')->toString();
        $currency = Str::of($response->json('balance'))->before(' ')->toString();

        return Balance::make(
            balance: floatval($balance),
            currency: Currency::from($currency),
        );
    }
}
