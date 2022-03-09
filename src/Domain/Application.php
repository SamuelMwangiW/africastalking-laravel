<?php

namespace SamuelMwangiW\Africastalking\Domain;

use Illuminate\Http\Client\Response;
use SamuelMwangiW\Africastalking\Factories\AccountFactory;
use SamuelMwangiW\Africastalking\Requests\Application\BalanceRequest;

class Application
{
    /**
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \SamuelMwangiW\Africastalking\Exceptions\CredentialsMissing
     */
    public function balance()
    {
        return AccountFactory::make(
            data: BalanceRequest::build()->fetch()
        );
    }
}
