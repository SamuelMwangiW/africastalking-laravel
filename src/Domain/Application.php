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
            data: BalanceRequest::build()->asForm()->fetch()
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
