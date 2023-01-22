<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Domain;

use Illuminate\Support\Str;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\Saloon\Requests\Payment\WalletBalanceRequest;
use SamuelMwangiW\Africastalking\ValueObjects\Balance;
use Exception;
use ReflectionException;

class Wallet
{
    /**
     * @return Balance
     * @throws ReflectionException
     * @throws \Saloon\Exceptions\InvalidResponseClassException
     * @throws \Saloon\Exceptions\PendingRequestException
     */
    public function balance(): Balance
    {
        $request = new WalletBalanceRequest();
        $response = $request->send()->throw();

        if ('Success' !== $response->json('status')) {
            throw new Exception('Failed to fetch wallet balance');
        }

        $balance = Str::of($response->json('balance'))->after(' ')->toString();
        $currency = Str::of($response->json('balance'))->before(' ')->toString();

        return Balance::make(
            balance: floatval($balance),
            currency: Currency::from($currency),
        );
    }
}
