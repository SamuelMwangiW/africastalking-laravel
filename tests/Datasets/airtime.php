<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\ValueObjects\AirtimeTransaction;

use function Pest\Faker\faker;

dataset('airtime-transactions', function () {
    yield fn () => AirtimeTransaction::make(
        phoneNumber: '+254700072929',
        currency: Currency::KENYA,
        amount: faker()->numberBetween(10, 300)
    );

    yield fn () => AirtimeTransaction::make(
        phoneNumber: '+256783879001',
        currency: Currency::UGANDA,
        amount: faker()->numberBetween(100, 1_000)
    );

    yield fn () => AirtimeTransaction::make(
        phoneNumber: '+255757022731',
        currency: Currency::TANZANIA,
        amount: faker()->numberBetween(1000, 3000)
    );

    yield fn () => AirtimeTransaction::make(
        phoneNumber: '+2348160663047',
        currency: Currency::NIGERIA,
        amount: faker()->numberBetween(100, 1_000)
    );
});

dataset('airtime-amount', [
    fn () => faker()->numberBetween(10, 500),
]);
