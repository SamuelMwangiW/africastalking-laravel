<?php

namespace SamuelMwangiW\Africastalking\Transporter\Requests\Airtime;

use SamuelMwangiW\Africastalking\Transporter\Requests\AfricastalkingRequest;

class SendRequest extends AfricastalkingRequest
{
    protected string $path = 'airtime/send';
}
