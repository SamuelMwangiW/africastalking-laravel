<?php

use function Pest\Faker\faker;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\ValueObjects\AirtimeTransaction;

dataset('airtime-transactions', [
    [
        fn () => AirtimeTransaction::make(
            phoneNumber: '+254720123123',
            currency: Currency::KENYA,
            amount: faker()->numberBetween(100, 300)
        ),
        fn () => AirtimeTransaction::make(
            phoneNumber: '+256783879001',
            currency: Currency::UGANDA,
            amount: faker()->numberBetween(100, 300)
        ),
        fn () => AirtimeTransaction::make(
            phoneNumber: '+260977528773',
            currency: Currency::ZAMBIA,
            amount: faker()->numberBetween(100, 300)
        ),
        fn () => AirtimeTransaction::make(
            phoneNumber: '+27714225174',
            currency: Currency::SOUTH_AFRICA,
            amount: faker()->numberBetween(100, 300)
        ),
        fn () => AirtimeTransaction::make(
            phoneNumber: '+2348160663047',
            currency: Currency::NIGERIA,
            amount: faker()->numberBetween(100, 300)
        ),
    ],
]);
