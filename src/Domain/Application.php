<?php

namespace SamuelMwangiW\Africastalking\Domain;

use SamuelMwangiW\Africastalking\Factories\AccountFactory;
use SamuelMwangiW\Africastalking\Requests\Application\BalanceRequest;
use SamuelMwangiW\Africastalking\ValueObjects\AccountDTO;

class Application
{
    /**
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \SamuelMwangiW\Africastalking\Exceptions\CredentialsMissing
     */
    public function balance(): AccountDTO
    {
        return AccountFactory::make(
            data: BalanceRequest::build()->fetch()
        );
    }
}
