<?php

namespace SamuelMwangiW\Africastalking\Requests\Application;

use SamuelMwangiW\Africastalking\Requests\AfricastalkingRequest;

class BalanceRequest extends AfricastalkingRequest
{
    protected string $method = 'GET';

    protected string $path = 'user';
}
