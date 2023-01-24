<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Domain;

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

        return $response->dto();
    }
}
