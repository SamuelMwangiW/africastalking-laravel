<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Enum;

enum Currency: string
{
    case KENYA = 'KES';
    case UGANDA = 'UGX';
    case TANZANIA = 'TZS';
    case NIGERIA = 'NGN';
    case MALAWI = 'MWK';
    case ZAMBIA = 'ZMK';
    case SOUTH_AFRICA = 'ZAR';
    case WEST_AFRICA = 'XOF';
    case GHANA = 'GHS';
    case RWANDA = 'RWF';
    case ETHIOPIA = 'ETB';
    case INTERNATIONAL = 'USD';
}
