<?php

namespace SamuelMwangiW\Africastalking\Transporter\Requests\Payment;

use SamuelMwangiW\Africastalking\Transporter\Requests\AfricastalkingRequest;

class WalletBalanceRequest extends AfricastalkingRequest
{
    protected string $method = 'GET';
    protected string $path = 'query/wallet/balance';

    protected string $liveBaseUrl = 'https://payments.africastalking.com/';
    protected string $sandboxBaseUrl = 'https://payments.sandbox.africastalking.com/';
}
