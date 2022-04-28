<?php

use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\Factories\AccountFactory;
use SamuelMwangiW\Africastalking\ValueObjects\Balance;

it('respects the DTOContract ', function () {
    $account = new Balance(
        amount: 6000,
        currency: Currency::UGANDA,
    );

    expect($account)
        ->toBeInstanceOf(DTOContract::class);
});

it('can construct an AccountDTO class', function () {
    $account = new Balance(
        amount: 6000,
        currency: Currency::UGANDA,
    );

    expect($account)
       ->toBeInstanceOf(Balance::class)
       ->currency->toBe(Currency::UGANDA)
       ->amount->toBe(6000.00);
});

it('can construct an Account using AccountFactory', function () {
    $account = AccountFactory::make(
        ['UserData' => ['balance' => 'UGX 9876.00']]
    );

    expect($account)
       ->toBeInstanceOf(Balance::class)
       ->currency->toBe(Currency::UGANDA)
       ->amount->toBe(9876.00);
});

test('AccountFactory defaults to USD for unknown currency', function () {
    $account = AccountFactory::make(
        ['UserData' => ['balance' => 'KPW 9876.00']]
    );

    expect($account)
       ->toBeInstanceOf(Balance::class)
       ->currency->toBe(Currency::INTERNATIONAL)
       ->amount->toBe(9876.00);
})->markAsRisky();

it('can make an Account statically', function () {
    $account = Balance::make(balance: 67890.00, currency: Currency::INTERNATIONAL);

    expect($account)
        ->toBeInstanceOf(Balance::class)
        ->currency->toBe(Currency::INTERNATIONAL)
        ->amount->toBe(67890.00);
});

it('can be cast to string', function () {
    $account = new Balance(
        amount: 6000,
        currency: Currency::UGANDA,
    );

    expect((string)$account)
        ->toBe('UGX 6000');
});

it('can be cast to array', function () {
    $account = new Balance(
        amount: 345678.5,
        currency: Currency::TANZANIA,
    );

    expect($account->__toArray())
        ->toBe(['amount' => 345678.5,'currency' => 'TZS','balance' => 'TZS 345678.5']);
});
