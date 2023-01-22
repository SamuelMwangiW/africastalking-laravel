<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Enum;

enum PaymentCategory: string
{
    case BANK_CHECKOUT = 'BankCheckout';
    case CARD_CHECKOUT = 'CardCheckout';
    case MOBILE_CHECKOUT = 'MobileCheckout';
    case MOBILE_C2B = 'MobileC2B';
    case MOBILE_B2C = 'MobileB2C';
    case MOBILE_B2B = 'MobileB2B';
    case BANK_TRANSFER = 'BankTransfer';
    case WALLET_TRANSFER = 'WalletTransfer';
    case USER_STASH_TOPUP = 'UserStashTopup';
}
