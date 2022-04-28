<?php

namespace SamuelMwangiW\Africastalking\Transporter\Requests\Payment;

class WalletBalanceRequest extends PaymentRequest
{
    protected string $method = 'GET';
    protected string $path = 'query/wallet/balance';
}
