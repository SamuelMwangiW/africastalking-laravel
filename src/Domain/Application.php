<?php

namespace SamuelMwangiW\Africastalking\Domain;

use SamuelMwangiW\Africastalking\Factories\AccountFactory;
use SamuelMwangiW\Africastalking\Saloon\Requests\Application\BalanceRequest;
use SamuelMwangiW\Africastalking\ValueObjects\Balance;

class Application
{
    /**
     * @return Balance
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     * @throws \Sammyjo20\Saloon\Exceptions\SaloonException
     * @throws \Sammyjo20\Saloon\Exceptions\SaloonRequestException
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
     * @throws \Sammyjo20\Saloon\Exceptions\SaloonException
     * @throws \Sammyjo20\Saloon\Exceptions\SaloonRequestException
     */
    public function data(): Balance
    {
        return $this->balance();
    }
}
