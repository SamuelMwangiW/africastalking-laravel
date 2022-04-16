<?php

namespace SamuelMwangiW\Africastalking\Transporter\Requests\Application;

use SamuelMwangiW\Africastalking\Transporter\Requests\AfricastalkingRequest;

class BalanceRequest extends AfricastalkingRequest
{
    protected string $method = 'GET';

    protected string $path = 'user';
}
