<?php

namespace SamuelMwangiW\Africastalking\Domain;

use Illuminate\Http\Client\RequestException;
use SamuelMwangiW\Africastalking\Factories\AccountFactory;
use SamuelMwangiW\Africastalking\Transporter\Requests\Application\BalanceRequest;
use SamuelMwangiW\Africastalking\ValueObjects\Account;

class Application
{
    /**
     * @throws RequestException
     */
    public function balance(): Account
    {
        return AccountFactory::make(
            data: BalanceRequest::build()->fetch()
        );
    }
}
