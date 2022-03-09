<?php

namespace SamuelMwangiW\Africastalking\Domain;

use Illuminate\Http\Client\RequestException;
use SamuelMwangiW\Africastalking\Factories\AccountFactory;
use SamuelMwangiW\Africastalking\Requests\Application\BalanceRequest;
use SamuelMwangiW\Africastalking\ValueObjects\AccountDTO;

class Application
{
    /**
     * @throws RequestException
     */
    public function balance(): AccountDTO
    {
        return AccountFactory::make(
            data: BalanceRequest::build()->fetch()
        );
    }
}
