<?php

namespace SamuelMwangiW\Africastalking\Domain;

use SamuelMwangiW\Africastalking\Factories\AccountFactory;
use SamuelMwangiW\Africastalking\Saloon\Requests\Application\BalanceRequest;
use SamuelMwangiW\Africastalking\ValueObjects\Balance;

class Application
{
    /**
     * @return Balance
     * @throws \ReflectionException
     * @throws \Saloon\Exceptions\InvalidResponseClassException
     * @throws \Saloon\Exceptions\PendingRequestException
     */
    public function balance(): Balance
    {
        $response = BalanceRequest::make()
            ->send()
            ->throw()
            ->json();

        return AccountFactory::make(
            data: $response
        );
    }

    /**
     * @return Balance
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function data(): Balance
    {
        return $this->balance();
    }
}
