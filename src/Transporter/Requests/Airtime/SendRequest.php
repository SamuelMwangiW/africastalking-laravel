<?php

namespace SamuelMwangiW\Africastalking\Transporter\Requests\Airtime;

use Illuminate\Http\Client\PendingRequest;
use SamuelMwangiW\Africastalking\Transporter\Requests\AfricastalkingRequest;

/** @mixin PendingRequest */
class SendRequest extends AfricastalkingRequest
{
    protected string $path = 'airtime/send';
}
