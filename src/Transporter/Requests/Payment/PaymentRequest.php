<?php

namespace SamuelMwangiW\Africastalking\Transporter\Requests\Payment;

use SamuelMwangiW\Africastalking\Transporter\Requests\AfricastalkingRequest;

class PaymentRequest extends AfricastalkingRequest
{
    protected string $liveBaseUrl = 'https://payments.africastalking.com/';
    protected string $sandboxBaseUrl = 'https://payments.sandbox.africastalking.com/';
}
