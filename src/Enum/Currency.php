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
    case ZAMBIA = 'ZMW';
    case SOUTH_AFRICA = 'ZAR';
    case WEST_AFRICA = 'XOF';
    case GHANA = 'GHS';
    case RWANDA = 'RWF';
    case ETHIOPIA = 'ETB';
    case INTERNATIONAL = 'USD';

    public function minimumAirtimeAmount(): int
    {
        return match ($this) {
            Currency::KENYA,
            Currency::ZAMBIA,
            Currency::SOUTH_AFRICA,
            Currency::ETHIOPIA => 5,
            Currency::UGANDA,
            Currency::NIGERIA => 50,
            Currency::TANZANIA => 500,
            Currency::MALAWI => 300,
            Currency::WEST_AFRICA,
            Currency::RWANDA => 100,
            Currency::GHANA,
            Currency::INTERNATIONAL => 1,
        };
    }
}
