<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\ValueObjects\AirtimeTransaction;

use function Pest\Faker\faker;

dataset('airtime-transactions', [
    'KENYA airtime transaction to +254700072929' => fn () => AirtimeTransaction::make(
        phoneNumber: Arr::random(['+254700072924','+254700072926','+254700072928','+254700072929']),
        currency: Currency::KENYA,
        amount: faker()->numberBetween(10, 300)
    ),

    'UGANDA airtime transaction to +256783879001' => fn () => AirtimeTransaction::make(
        phoneNumber: Arr::random(['+256783879001','+256783879002','+256783879003','+256783879004']),
        currency: Currency::UGANDA,
        amount: faker()->numberBetween(100, 1_000)
    ),

    'TANZANIA airtime transaction to +255757022731' => fn () => AirtimeTransaction::make(
        phoneNumber: Arr::random(['+255757022731','+255757022732','+255757022733','+255757022734']),
        currency: Currency::TANZANIA,
        amount: faker()->numberBetween(1000, 3000)
    ),

    'NIGERIA airtime transaction to +2348160663047' => fn () => AirtimeTransaction::make(
        phoneNumber: Arr::random(['+2348160663047','+2348160663048','+2348160663049','+2348160663040']),
        currency: Currency::NIGERIA,
        amount: faker()->numberBetween(100, 1_000)
    ),
]);

dataset('airtime-amount', [
    fn () => faker()->numberBetween(10, 500),
]);
