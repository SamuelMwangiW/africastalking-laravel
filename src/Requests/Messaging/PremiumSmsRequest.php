<?php

namespace SamuelMwangiW\Africastalking\Requests\Messaging;

use SamuelMwangiW\Africastalking\Requests\AfricastalkingRequest;

class PremiumSmsRequest extends AfricastalkingRequest
{
    protected string $path = 'messaging';

    protected string $liveBaseUrl = 'https://content.africastalking.com/version1/';
}
