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
        carrier: 'Safaricom',
        countryCode: 254,
        networkCode: 'Safaricom',
        numberType: 'Mobile',
    );

    expect($account)
        ->toBeInstanceOf(PhoneNumber::class)
        ->number->toBe($phone)
        ->carrier->toBe('Safaricom')
        ->networkCode->toBe('Safaricom')
        ->numberType->toBe('Mobile')
        ->countryCode->toBe(254);
})->with('phone-numbers');

it('can be constructed with only the phoneNumber', function (string $phone): void {
    $account = new PhoneNumber(
        number: $phone,
    );

    expect($account)
        ->toBeInstanceOf(PhoneNumber::class)
        ->number->toBe($phone)
        ->carrier->toBeNull()
        ->networkCode->toBeNull()
        ->numberType->toBeNull()
        ->countryCode->toBeNull();
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
    $account = (array) new PhoneNumber(
        number: $phone,
        carrier: 'Safaricom',
        countryCode: 254,
        networkCode: 'Safaricom',
        numberType: 'Mobile',
    );

    expect($account)
        ->toBeArray()
        ->toBe([
            'number' => $phone,
            'carrier' => 'Safaricom',
            'countryCode' => 254,
            'networkCode' => 'Safaricom',
            'numberType' => 'Mobile',
        ]);
})->with('phone-numbers');

it('has the expected array shape', function (array $data): void {
    $account = new PhoneNumber(
        number: $phone = data_get($data, 'number'),
        carrier: $carrier = data_get($data, 'carrier'),
        countryCode: $countryCode = data_get($data, 'countryCode'),
        networkCode: $networkCode = data_get($data, 'networkCode'),
        numberType: $numberType = data_get($data, 'numberType'),
    );

    expect($account->__toArray())
        ->toBeArray()
        ->toBe([
            'number' => $phone,
            'carrier' => $carrier,
            'countryCode' => $countryCode,
            'networkCode' => $networkCode,
            'numberType' => $numberType,
        ]);
})->with([
    'full' => fn() => [
        'number' => fake()->e164PhoneNumber(),
        'carrier' => 'Safaricom',
        'countryCode' => 254,
        'networkCode' => 'Safaricom',
        'numberType' => 'Mobile',
    ],
    'only phoneNumber' => fn() => [
        'number' => fake()->e164PhoneNumber(),
    ],'full with fakes' => fn() => [
        'number' => fake()->e164PhoneNumber(),
        'carrier' => fake()->company(),
        'countryCode' => fake()->numberBetween(1, 500),
        'networkCode' => fake()->word(),
        'numberType' => fake()->word(),
    ],
]);
