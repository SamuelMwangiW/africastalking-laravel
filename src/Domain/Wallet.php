<?php

namespace SamuelMwangiW\Africastalking\Domain;

use Illuminate\Support\Str;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\Saloon\Requests\Payment\WalletBalanceRequest;
use SamuelMwangiW\Africastalking\ValueObjects\Balance;

class Wallet
{
    /**
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \Exception
     */
    public function balance(): Balance
    {
        $request = new WalletBalanceRequest();
        $response = $request->send();

        if ($response->failed()) {
            /** @phpstan-ignore-next-line */
            throw $response->toException();
        }

        if ($response->json('status') !== 'Success') {
            throw new \Exception('Failed to fetch wallet balance');
        }

        $balance = Str::of($response->json('balance'))->after(' ')->toString();
        $currency = Str::of($response->json('balance'))->before(' ')->toString();

        return new Balance(
            amount: floatval($balance),
            currency: Currency::from($currency),
        );
    }
}
