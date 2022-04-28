<?php

namespace SamuelMwangiW\Africastalking\Domain;

use Illuminate\Http\Client\RequestException;
use SamuelMwangiW\Africastalking\Factories\AccountFactory;
use SamuelMwangiW\Africastalking\Transporter\Requests\Application\BalanceRequest;
use SamuelMwangiW\Africastalking\ValueObjects\Balance;

class Application
{
    /**
     * @throws RequestException
     */
    public function balance(): Balance
    {
        return AccountFactory::make(
        /** @phpstan-ignore-next-line  */
            data: BalanceRequest::build()->asForm()->fetch()
        );
    }
}
