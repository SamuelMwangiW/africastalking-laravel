<?php

namespace SamuelMwangiW\Africastalking\Domain;

use Illuminate\Http\Client\RequestException;
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
        $request = new BalanceRequest();
        $response = $request->send();

        if ($response->failed()) {
            /** @phpstan-ignore-next-line */
            throw $response->toException();
        }

        return AccountFactory::make(
            data: $response->json()
        );
    }

    /**
     * @throws RequestException
     */
    public function data(): Balance
    {
        return $this->balance();
    }
}
