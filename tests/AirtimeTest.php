<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Pest\Expectation;
use SamuelMwangiW\Africastalking\Domain\Airtime;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\Exceptions\AfricastalkingException;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\ValueObjects\AirtimeTransaction;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;

it('resolves the application class')
    ->expect(fn () => Africastalking::airtime())
    ->toBeInstanceOf(Airtime::class);

it('can add a recipient', function (string $phone, string $currency, int $amount): void {
    $service = Africastalking::airtime()
        ->to(
            phoneNumber: $phone,
            currencyCode: $currency,
            amount: $amount
        );

    expect($service)
        ->recipients->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->recipients->first()->phoneNumber->toBeInstanceOf(PhoneNumber::class)
        ->recipients->first()->currencyCode->toBeInstanceOf(Currency::class);
})->with('phone-numbers', 'currencies', 'airtime-amount');

it('can add a recipient from a transaction object', function (AirtimeTransaction $transaction): void {
    $service = Africastalking::airtime()->to($transaction);

    expect($service)
        ->recipients->toHaveCount(1)
        ->recipients->each(
            fn ($recipient) => $recipient
                ->phoneNumber->toBe($transaction->phoneNumber)
                ->currencyCode->toBe($transaction->currencyCode)
                ->amount->toBeInt()
        );
})->with('airtime-transactions');

it('can add multiple recipients', function (string $phone, string $currency, int $amount): void {
    $service = Africastalking::airtime()
        ->add(
            phoneNumber: $phone,
            currencyCode: $currency,
            amount: $amount,
        )
        ->add(
            phoneNumber: '+256706123456',
            currencyCode: $currency,
            amount: $amount
        );

    expect($service)
        ->recipients->toBeInstanceOf(Collection::class)
        ->toHaveCount(2)
        ->recipients->each(
            fn ($recipient) => $recipient
                ->phoneNumber->toBeInstanceOf(PhoneNumber::class)
                ->currencyCode->toBeInstanceOf(Currency::class)
                ->amount->toBeInt()
        );
})->with('phone-numbers', 'currencies', 'airtime-amount');

it('throws an exception for invalid currency', function (string $phone, int $amount): void {
    Africastalking::airtime()
        ->to(
            phoneNumber: $phone,
            currencyCode: 'KPW',
            amount: $amount
        );
})->with('phone-numbers', 'airtime-amount')->throws(AfricastalkingException::class);

it('throws an exception for amounts less than 5', function (string $phone): void {
    Africastalking::airtime()
        ->to(
            phoneNumber: $phone,
            amount: 1
        );
})->with('phone-numbers')->throws(AfricastalkingException::class);

it('sends airtime to a single recipient', function (AirtimeTransaction $transaction): void {
    $result = Africastalking::airtime()
        ->idempotent(fake()->uuid())
        ->to($transaction)
        ->send();

    if (
        'A duplicate request was received within the last 5 minutes' === data_get($result, 'errorMessage')
    ) {
        test()->doesNotPerformAssertions();

        return;
    }

    expect($result)
        ->toBeArray()
        ->toHaveKeys([
            'errorMessage',
            'numSent',
            'totalAmount',
            'totalDiscount',
            'responses',
        ])
        ->and($result['responses'])
        ->toBeArray()
        ->toHaveCount(1)
        ->and($result['responses'])
        ->each(
            fn (Expectation $response) => $response->toHaveKeys(
                ['phoneNumber', 'errorMessage', 'requestId', 'discount']
            )
        )
        ->and(data_get($result, 'numSent'))->toBe(1);
})->with('airtime-transactions');

it('sends airtime to multiple recipients', function (int $amount, string $phone): void {
    $result = Africastalking::airtime()
        ->idempotent(fake()->uuid())
        ->to($phone, 'KES', $amount)
        ->to(phoneNumber: '+254712345678', amount: $amount)
        ->send();

    if (
        'A duplicate request was received within the last 5 minutes' === data_get($result, 'errorMessage')
    ) {
        test()->doesNotPerformAssertions();

        return;
    }

    expect($result)
        ->toBeArray()
        ->toHaveKeys([
            'errorMessage',
            'numSent',
            'totalAmount',
            'totalDiscount',
            'responses',
        ])
        ->and($result['responses'])
        ->toBeArray()
        ->toHaveCount(2)
        ->and($result['responses'])
        ->each(
            fn (Expectation $response) => $response->toHaveKeys(
                ['phoneNumber', 'errorMessage', 'requestId', 'discount']
            )
        )->and(data_get($result, 'numSent'))->toBe(2);
})->with('airtime-amount', 'phone-numbers')->markAsRisky();
