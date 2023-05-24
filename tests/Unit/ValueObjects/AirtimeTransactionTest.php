<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\ValueObjects\AirtimeTransaction;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;

it('respects the DTO Contract', function (string $phone, string $currency, callable $amount): void {
    $transaction = new AirtimeTransaction(
        phoneNumber: PhoneNumber::make($phone),
        currencyCode: Currency::from($currency),
        amount: value($amount)
    );

    expect($transaction)
        ->toBeInstanceOf(DTOContract::class);
})->with('phone-numbers', 'currencies', 'airtime-amount');

it('can construct an object', function (string $phone, string $currency, callable $amount): void {
    $transaction = new AirtimeTransaction(
        phoneNumber: PhoneNumber::make($phone),
        currencyCode: Currency::from($currency),
        amount: value($amount)
    );

    expect($transaction)
        ->toBeInstanceOf(AirtimeTransaction::class)
        ->currencyCode->value->toBe($currency)
        ->phoneNumber->number->toBe($phone);
})->with('phone-numbers', 'currencies', 'airtime-amount');

it('can be cast to string', function (string $phone, string $currency): void {
    $transaction = new AirtimeTransaction(
        phoneNumber: PhoneNumber::make($phone),
        currencyCode: Currency::from($currency),
        amount: 1000
    );

    $transactionString = '{"phoneNumber":"'.$phone.'","amount":"'.$currency.' 1000"}';

    expect(strval($transaction))
        ->toBe($transactionString);
})->with('phone-numbers', 'currencies');

it('can be encoded to string', function (string $phone, string $currency): void {
    $transaction = new AirtimeTransaction(
        PhoneNumber::make($phone),
        Currency::from($currency),
        1000
    );

    $transactionString = '{"phoneNumber":"'.$phone.'","amount":"'.$currency.' 1000"}';

    expect((string)$transaction)
        ->toBe($transactionString);
})->with('phone-numbers', 'currencies');

it('can be cast to array', function (string $phone, string $currency, callable $amount): void {
    $transaction = new AirtimeTransaction(
        phoneNumber: PhoneNumber::make($phone),
        currencyCode: Currency::from($currency),
        amount: value($amount)
    );

    expect((array)$transaction)
        ->toBeArray();
    //        ->toBe(['phoneNumber' => $phone, 'amount' => "{$currency} {$amount}"]);
})->with('phone-numbers', 'currencies', 'airtime-amount');
