<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Pest\Expectation;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use SamuelMwangiW\Africastalking\Domain\Airtime;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\Exceptions\AfricastalkingException;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\Saloon\Requests\Airtime\SendRequest;
use SamuelMwangiW\Africastalking\ValueObjects\AirtimeRecipientResponse;
use SamuelMwangiW\Africastalking\ValueObjects\AirtimeResponse;
use SamuelMwangiW\Africastalking\ValueObjects\AirtimeTransaction;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;

it('resolves the application class')
    ->expect(fn() => Africastalking::airtime())
    ->toBeInstanceOf(Airtime::class);

it('can add a recipient', function (string $phone, string $currency, int $amount): void {
    $service = Africastalking::airtime()
        ->to(
            phoneNumber: $phone,
            currencyCode: $currency,
            amount: $amount,
        );

    expect($service)
        ->recipients->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->recipients->first()->phoneNumber->toBeInstanceOf(PhoneNumber::class)
        ->recipients->first()->currencyCode->toBeInstanceOf(Currency::class);
})->with([
    'KES' => ['+254700123123', 'KES', fake()->numberBetween(10, 100)],
    'UGX' => ['+256700123123', 'UGX', fake()->numberBetween(50, 100)],
    'TZS' => ['+255700123123', 'TZS', fake()->numberBetween(500, 1_000)],
    'NGN' => ['+2347001923123', 'NGN', fake()->numberBetween(50, 100)],
    'MWK' => ['+254700123123', 'MWK', fake()->numberBetween(300, 500)],
    'ZMK' => ['+254700123123', 'ZMK', fake()->numberBetween(10, 100)],
    'ZAR' => ['+254700123123', 'ZAR', fake()->numberBetween(10, 100)],
    'XOF' => ['+254700123123', 'XOF', fake()->numberBetween(100, 500)],
    'GHS' => ['+254700123123', 'GHS', fake()->numberBetween(10, 100)],
    'RWF' => ['+254700123123', 'RWF', fake()->numberBetween(100, 500)],
    'ETB' => ['+254700123123', 'ETB', fake()->numberBetween(10, 100)],
    'USD' => ['+254700123123', 'USD', fake()->numberBetween(1, 50)],
]);

it('can add a recipient from a transaction object', function (AirtimeTransaction $transaction): void {
    $service = Africastalking::airtime()->to($transaction);

    expect($service)
        ->recipients->toHaveCount(1)
        ->recipients->each(
            fn($recipient) => $recipient
                ->phoneNumber->toBe($transaction->phoneNumber)
                ->currencyCode->toBe($transaction->currencyCode)
                ->amount->toBeInt(),
        );
})->with('airtime-transactions');

it('can add a recipient using currency Enum', function (string $currencyCode): void {

    $service = Africastalking::airtime()
        ->to(
            phoneNumber: $phoneNumber = fake()->e164PhoneNumber(),
            currencyCode: Currency::from($currencyCode),
            amount: $amount = fake()->numberBetween(500, 1000),
        );

    expect($service)
        ->recipients->toHaveCount(1)
        ->recipients->each(
            fn($recipient) => $recipient
                ->phoneNumber->number->toBe($phoneNumber)
                ->currencyCode->value->toBe($currencyCode)
                ->amount->toBeInt()->toBe($amount),
        );
})->with('currencies');

it('can add multiple recipients', function (string $phone, string $currency, callable $amount): void {
    $service = Africastalking::airtime()
        ->add(
            phoneNumber: $phone,
            currencyCode: $currency,
            amount: value($amount),
        )
        ->add(
            phoneNumber: '+256706123456',
            currencyCode: $currency,
            amount: value($amount),
        );

    expect($service)
        ->recipients->toBeInstanceOf(Collection::class)
        ->toHaveCount(2)
        ->recipients->each(
            fn($recipient) => $recipient
                ->phoneNumber->toBeInstanceOf(PhoneNumber::class)
                ->currencyCode->toBeInstanceOf(Currency::class)
                ->amount->toBeInt(),
        );
})->with('phone-numbers', 'currencies', 'airtime-amount');

it('throws an exception for invalid currency', function (string $phone, callable $amount): void {
    Africastalking::airtime()
        ->to(
            phoneNumber: $phone,
            currencyCode: 'KPW',
            amount: value($amount),
        );
})->with('phone-numbers', 'airtime-amount')->throws(AfricastalkingException::class);

it('throws an exception for amounts less than supported', function (string $currencyCode, int $amount): void {
    Africastalking::airtime()
        ->to(
            phoneNumber: fake()->e164PhoneNumber(),
            currencyCode: $currencyCode,
            amount: $amount,
        );
})->with([
    'KES' => ['KES', 4],
    'UGX' => ['UGX', 49],
    'TZS' => ['TZS', 499],
    'NGN' => ['NGN', 49],
    'MWK' => ['MWK', 299],
    'ZMK' => ['ZMK', 4],
    'ZAR' => ['ZAR', 4],
    'XOF' => ['XOF', 99],
    'GHS' => ['GHS', 0],
    'RWF' => ['RWF', 99],
    'ETB' => ['ETB', 4],
    'USD' => ['USD', 0],
])->throws(AfricastalkingException::class);

it('sends airtime to a single recipient', function (AirtimeTransaction $transaction): void {
    Saloon::fake([
        SendRequest::class => MockResponse::fixture('airtime/send'),
    ]);

    $result = Africastalking::airtime()
        ->idempotent(fake()->uuid())
        ->to($transaction)
        ->send();

    expect($result)
        ->toBeInstanceOf(AirtimeResponse::class)
        ->numSent->toBe(1)
        ->errorMessage->toBe('None')
        ->and($result->responses)
        ->toBeInstanceOf(Collection::class)
        ->count()->toBe(1)
        ->first()->toBeInstanceOf(AirtimeRecipientResponse::class);
})->with('airtime-transactions');

it('sends airtime to multiple recipients', function (callable $amount, string $phone): void {
    Saloon::fake([
        SendRequest::class => MockResponse::fixture('airtime/send-multiple'),
    ]);
    $amount = value($amount);

    $result = Africastalking::airtime()
        ->idempotent(fake()->uuid())
        ->to($phone, 'KES', $amount)
        ->to(phoneNumber: '+254712345678', amount: $amount)
        ->send();

    expect($result)
        ->toBeInstanceOf(AirtimeResponse::class)
        ->numSent->toBe(2)
        ->errorMessage->toBe('None')
        ->and($result->responses)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(2)
        ->each(
            fn(Expectation $transaction) => $transaction->toBeInstanceOf(AirtimeRecipientResponse::class),
        );
})->with('airtime-amount', 'phone-numbers');
