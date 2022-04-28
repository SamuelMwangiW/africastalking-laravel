<?php

namespace SamuelMwangiW\Africastalking\Transporter\Requests\Payment;

class MobileCheckoutRequest extends PaymentRequest
{
    protected string $path = 'mobile/checkout/request';
}
