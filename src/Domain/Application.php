<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Domain;

use SamuelMwangiW\Africastalking\Saloon\Requests\Application\BalanceRequest;
use SamuelMwangiW\Africastalking\ValueObjects\Balance;
use ReflectionException;

class Application
{
    /**
     * @return Balance
     * @throws ReflectionException
     * @throws \Saloon\Exceptions\InvalidResponseClassException
     * @throws \Saloon\Exceptions\PendingRequestException
     */
    public function balance(): Balance
    {
        return BalanceRequest::make()
            ->send()
            ->throw()
            ->dto();
    }

    /**
     * @return Balance
     * @throws ReflectionException
     * @throws \Saloon\Exceptions\InvalidResponseClassException
     * @throws \Saloon\Exceptions\PendingRequestException
     */
    public function data(): Balance
    {
        return $this->balance();
    }
}
