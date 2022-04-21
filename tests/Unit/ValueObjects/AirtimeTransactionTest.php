<?php

use function Pest\Faker\faker;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\ValueObjects\AirtimeTransaction;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;

it('can construct an object', function (string $phone, string $currency) {
    $transaction = new AirtimeTransaction(
        PhoneNumber::make($phone),
        Currency::from($currency),
        faker()->numberBetween(10, 1000)
    );

    expect($transaction)
        ->toBeInstanceOf(AirtimeTransaction::class)
        ->currencyCode->value->toBe($currency)
        ->phoneNumber->number->toBe($phone);
})->with('phone-numbers', 'currencies');

it('can be cast to string', function (string $phone, string $currency) {
    $transaction = new AirtimeTransaction(
        PhoneNumber::make($phone),
        Currency::from($currency),
        1000
    );

    $transactionString = '{"phoneNumber":"' . $phone . '","amount":"' . $currency . ' 1000"}';

    expect(strval($transaction))
        ->toBe($transactionString);
})->with('phone-numbers', 'currencies');

it('can be encoded to string', function (string $phone, string $currency) {
    $transaction = new AirtimeTransaction(
        PhoneNumber::make($phone),
        Currency::from($currency),
        1000
    );

    $transactionString = '{"phoneNumber":"' . $phone . '","amount":"' . $currency . ' 1000"}';

    expect((string)$transaction)
        ->toBe($transactionString);
})->with('phone-numbers', 'currencies');
