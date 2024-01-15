<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Domain;

use Exception;
use ReflectionException;
use SamuelMwangiW\Africastalking\Saloon\Requests\Payment\WalletBalanceRequest;
use SamuelMwangiW\Africastalking\ValueObjects\Balance;

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
        $response = WalletBalanceRequest::make()->send()->throw();

        if ('Success' !== $response->json('status')) {
            throw new Exception('Failed to fetch wallet balance');
        }

        return $response->dto();
    }
}
