<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Enum;

enum PaymentSourceType: string
{
    case MOBILE = 'PhoneNumber';
    case BANK = 'BankAccount';
    case CARD = 'Card';
    case WALLET = 'Wallet';
    case STASH = 'UserStash';
}
