<?php

namespace SamuelMwangiW\Africastalking\Transporter\Requests\Voice;

use SamuelMwangiW\Africastalking\Transporter\Requests\AfricastalkingRequest;

class CallRequest extends AfricastalkingRequest
{
    protected string $liveBaseUrl = 'https://voice.africastalking.com/';
    protected string $sandboxBaseUrl = 'https://voice.sandbox.africastalking.com/';
    protected string $path = 'call';
}
