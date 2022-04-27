<?php

namespace SamuelMwangiW\Africastalking\Transporter\Requests\Payment;

use SamuelMwangiW\Africastalking\Transporter\Requests\AfricastalkingRequest;

class StashTopupRequest extends AfricastalkingRequest
{
    protected string $path = 'topup/stash';

    protected string $liveBaseUrl = 'https://payments.africastalking.com/';
    protected string $sandboxBaseUrl = 'https://payments.sandbox.africastalking.com/';
}
