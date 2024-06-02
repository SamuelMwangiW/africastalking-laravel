<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;

it('respects the DTOContract ', function (string $phone): void {
    $account = new PhoneNumber(
        number: $phone,
    );

    expect($account)
        ->toBeInstanceOf(DTOContract::class);
})->with('phone-numbers');

it('can be constructed', function (string $phone): void {
    $account = new PhoneNumber(
        number: $phone,
    );

    expect($account)
        ->toBeInstanceOf(PhoneNumber::class)
        ->number->toBe($phone);
})->with('phone-numbers');

it('can be generated using make', function (string $phone): void {
    $account = PhoneNumber::make(phone: $phone);

    expect($account)
        ->toBeInstanceOf(PhoneNumber::class)
        ->number->toBe($phone);
})->with('phone-numbers');

it('can be cast to string', function (string $phone): void {
    $account = PhoneNumber::make(phone: $phone);

    expect((string) $account)
        ->toBeString()
        ->toBe($phone);
})->with('phone-numbers');

it('can be cast to array', function (string $phone): void {
    $account = (array) PhoneNumber::make(phone: $phone);

    expect($account)
        ->toBeArray()
        ->toBe(['number' => $phone]);
})->with('phone-numbers');
