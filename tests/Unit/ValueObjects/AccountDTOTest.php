<?php

use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\Factories\AccountFactory;
use SamuelMwangiW\Africastalking\ValueObjects\Account;

it('respects the DTOContract ', function () {
    $account = new Account(
        balance: 6000,
        currency: Currency::UGANDA,
    );

    expect($account)
        ->toBeInstanceOf(DTOContract::class);
});

it('can construct an AccountDTO class', function () {
    $account = new Account(
        balance: 6000,
        currency: Currency::UGANDA,
    );

    expect($account)
       ->toBeInstanceOf(Account::class)
       ->currency->toBe(Currency::UGANDA)
       ->balance->toBe(6000.00);
});

it('can construct an Account using AccountFactory', function () {
    $account = AccountFactory::make(
        ['UserData' => ['balance' => 'UGX 9876.00']]
    );

    expect($account)
       ->toBeInstanceOf(Account::class)
       ->currency->toBe(Currency::UGANDA)
       ->balance->toBe(9876.00);
});

test('AccountFactory defaults to USD for unknown currency', function () {
    $account = AccountFactory::make(
        ['UserData' => ['balance' => 'KPW 9876.00']]
    );

    expect($account)
       ->toBeInstanceOf(Account::class)
       ->currency->toBe(Currency::INTERNATIONAL)
       ->balance->toBe(9876.00);
})->markAsRisky();

it('can make an Account statically', function () {
    $account = Account::make(balance: 67890.00, currency: Currency::INTERNATIONAL);

    expect($account)
        ->toBeInstanceOf(Account::class)
        ->currency->toBe(Currency::INTERNATIONAL)
        ->balance->toBe(67890.00);
});

it('can be cast to string', function () {
    $account = new Account(
        balance: 6000,
        currency: Currency::UGANDA,
    );

    expect((string)$account)
        ->toBe('UGX 6000');
});

it('can be cast to array', function () {
    $account = new Account(
        balance: 345678.5,
        currency: Currency::TANZANIA,
    );

    expect($account->__toArray())
        ->toBe(['amount' => 345678.5,'currency' => 'TZS','balance' => 'TZS 345678.5']);
});
