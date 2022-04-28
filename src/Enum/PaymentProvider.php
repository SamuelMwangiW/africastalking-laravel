<?php

namespace SamuelMwangiW\Africastalking\Enum;

enum PaymentProvider: string
{
    case MPESA = 'Mpesa';
    case TIGO_PESA = 'TigoTanzania';
    case SANDBOX = 'Athena';
}
