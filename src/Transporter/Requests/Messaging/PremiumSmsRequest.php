<?php

namespace SamuelMwangiW\Africastalking\Transporter\Requests\Messaging;

use SamuelMwangiW\Africastalking\Transporter\Requests\AfricastalkingRequest;

class PremiumSmsRequest extends AfricastalkingRequest
{
    protected string $path = 'messaging';

    protected string $liveBaseUrl = 'https://content.africastalking.com/version1/';
}
