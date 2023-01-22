<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Enum;

enum PaymentProvider: string
{
    case ADMIN = 'Admin';
    case FLUTTERWAVE = 'Flutterwave';
    case MPESA = 'Mpesa';
    case SANDBOX = 'Athena';
    case SEGOVIA = 'Segovia';
    case TIGO_PESA = 'TigoTanzania';
}
