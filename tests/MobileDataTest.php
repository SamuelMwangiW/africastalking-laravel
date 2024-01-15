<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use SamuelMwangiW\Africastalking\Domain\MobileData;
use SamuelMwangiW\Africastalking\Enum\BundlesUnit;
use SamuelMwangiW\Africastalking\Enum\BundlesValidity;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\Saloon\Requests\MobileData\SendRequest;
use SamuelMwangiW\Africastalking\ValueObjects\DataBundlesResponse;
use SamuelMwangiW\Africastalking\ValueObjects\DataBundlesResponseEntry;
use SamuelMwangiW\Africastalking\ValueObjects\MobileDataTransaction;

it('can be resolved')
    ->expect(fn() => africastalking()->mobileData())
    ->toBeInstanceOf(MobileData::class);

it('can be resolved via the Facade')
    ->expect(fn() => Africastalking::mobileData())
    ->toBeInstanceOf(MobileData::class);

it('can be resolved via bundles alias')
    ->expect(fn() => africastalking()->bundles())
    ->toBeInstanceOf(MobileData::class);

it('sends idempotency requests')
    ->expect(
        fn() => app(MobileData::class)->idempotent('key_123')
    )->toBeInstanceOf(MobileData::class)
    ->idempotencyKey()->toBe('key_123');

it('sets the recipients to an empty array by default', function (): void {
    $object = app(MobileData::class);

    expect($object)
        ->recipients->toBeInstanceOf(Collection::class)
        ->toHaveCount(0)
        ->toBeIterable()
        ->recipients->toArray()->toBe([]);
});

it('sets the default product Name from config', function (): void {
    config()->set('africastalking.payment.product-name', 'test');

    $object = app(MobileData::class);

    expect($object)
        ->productName->toBe('test');
});

it('sets the product Name fluently', function (string $string): void {
    $object = app(MobileData::class);
    $object->productName($string);

    expect($object)
        ->productName->toBe($string);
})->with('strings');

test('setting the product Name overrides the config value', function (string $string): void {
    config()->set('africastalking.payment.product-name', 'test');

    $object = app(MobileData::class);
    $object->productName($string);

    expect($object)->productName->toBe($string);
})->with('strings');

it('sets the recipients fluently', function (string $phone): void {
    $object = app(MobileData::class);
    $object->to(
        phoneNumber: $phone,
        quantity: 7,
        validity: BundlesValidity::DAILY
    );

    expect($object)
        ->recipients->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->each->toBeInstanceOf(MobileDataTransaction::class)
        ->recipients->first()->phoneNumber->number->toBe($phone);
})->with('phone-numbers');

it('sets multiple recipients', function (): void {
    $object = app(MobileData::class);
    $object
        ->to(
            phoneNumber: fake()->e164PhoneNumber(),
            quantity: 7,
            validity: BundlesValidity::DAILY
        )->to(
            phoneNumber: fake()->e164PhoneNumber(),
            quantity: 1,
            validity: BundlesValidity::WEEKLY,
            unit: BundlesUnit::GB
        )->to(
            phoneNumber: fake()->e164PhoneNumber(),
            quantity: 5,
            validity: BundlesValidity::MONTHLY,
            unit: BundlesUnit::GB
        );

    expect($object)
        ->recipients->toBeInstanceOf(Collection::class)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(MobileDataTransaction::class);
});

it('sends Data bundles request', function (string $phone): void {
    Saloon::fake([
        SendRequest::class => MockResponse::fixture('mobile-data/send'),
    ]);

    $object = app(MobileData::class);
    $result = $object
        ->to(
            phoneNumber: $phone,
            quantity: 7,
            validity: BundlesValidity::DAILY
        )
        ->idempotent(key: fake()->uuid())
        ->send();

    expect($result)
        ->toBeInstanceOf(DataBundlesResponse::class)
        ->entries->toHaveCount(1)
        ->each->toBeInstanceOf(DataBundlesResponseEntry::class);
})->with('phone-numbers');

it('sends Data bundles request to multiple users', function (): void {
    Saloon::fake([
        SendRequest::class => MockResponse::fixture('mobile-data/send-multiple'),
    ]);

    $object = app(MobileData::class);
    $result = $object
        ->to(
            phoneNumber: '+254722000000',
            quantity: 7,
            validity: BundlesValidity::DAILY
        )->to(
            phoneNumber: '+254720000000',
            quantity: 1,
            validity: BundlesValidity::WEEKLY,
            unit: BundlesUnit::GB
        )->to(
            phoneNumber: '+254726000000',
            quantity: 10,
            validity: BundlesValidity::MONTHLY,
            unit: BundlesUnit::GB
        )->idempotent(key: fake()->uuid())
        ->send();

    expect($result)
        ->toBeInstanceOf(DataBundlesResponse::class)
        ->entries->toHaveCount(3)
        ->each->toBeInstanceOf(DataBundlesResponseEntry::class);
})->with('phone-numbers');

it('defaults values for an invalid request', function (): void {
    Saloon::fake([
        SendRequest::class => MockResponse::fixture('mobile-data/invalid'),
    ]);

    $object = app(MobileData::class);
    $result = $object
        ->to(
            phoneNumber: fake()->e164PhoneNumber(),
            quantity: 7,
            validity: BundlesValidity::DAILY
        )->idempotent(key: fake()->uuid())
        ->send();

    expect($result)
        ->toBeInstanceOf(DataBundlesResponse::class)
        ->entries->toHaveCount(1)
        ->each->toBeInstanceOf(DataBundlesResponseEntry::class)
        ->and($result->entries->first())
        ->provider->toBe('Athena')
        ->transactionId->toBe('InvalidRequest');
});
