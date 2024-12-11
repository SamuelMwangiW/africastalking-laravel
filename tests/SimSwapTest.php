<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Pest\Expectation;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use SamuelMwangiW\Africastalking\Domain\SimSwap;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\Enum\Status;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\Saloon\Requests\SimSwap\SendRequest;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;
use SamuelMwangiW\Africastalking\ValueObjects\Responses\InsightsResponse;
use SamuelMwangiW\Africastalking\ValueObjects\Responses\InsightsResponseItem;

it('resolves the application class using simSwap')
    ->expect(fn() => Africastalking::simSwap())
    ->toBeInstanceOf(SimSwap::class);

it('resolves the application class using insights()')
    ->expect(fn() => Africastalking::insights())
    ->toBeInstanceOf(SimSwap::class);

it('can add a recipient using for', function (string $phone): void {
    $service = Africastalking::simSwap()->for(
        phoneNumber: $phone,
    );

    expect($service)
        ->numbers->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->numbers->first()->toBeInstanceOf(PhoneNumber::class)
        ->numbers->first()->number->toBe($phone);
})->with([
    'Safaricom Kenya' => ['+254700123123'],
    'MTN UG' => ['+256700123123'],
]);

it('can add a recipient using add', function (string $phone): void {
    $service = Africastalking::simSwap()->add(
        phoneNumber: $phone,
    );

    expect($service)
        ->numbers->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->numbers->first()->toBeInstanceOf(PhoneNumber::class)
        ->numbers->first()->number->toBe($phone);
})->with([
    'Safaricom Kenya' => ['+254700123123'],
    'MTN UG' => ['+256700123123'],
]);

it('can add multiple recipients', function (string $phone): void {
    $service = Africastalking::simSwap()
        ->add(phoneNumber: $phone)
        ->add(phoneNumber: '+256706123456');

    expect($service)
        ->numbers->toBeInstanceOf(Collection::class)
        ->toHaveCount(2)
        ->numbers->each(
            fn($recipient) => $recipient->toBeInstanceOf(PhoneNumber::class),
        )->recipients()->toBe([$phone, '+256706123456']);
})->with('phone-numbers');

it('fetches simSwap status a single recipient', function (string $phone): void {
    Saloon::fake([
        SendRequest::class => MockResponse::fixture('sim-swap/send'),
    ]);

    $result = Africastalking::simSwap()
        ->for($phone)
        ->idempotent(fake()->uuid())
        ->send();

    expect($result)
        ->toBeInstanceOf(InsightsResponse::class)
        ->status->toBe(Status::PROCESSED)
        ->cost->currency->toBe(Currency::INTERNATIONAL)
        ->and($result->items)
        ->toBeInstanceOf(Collection::class)
        ->count()->toBe(1)
        ->first()->toBeInstanceOf(InsightsResponseItem::class);
})->with([
    'Safaricom Kenya' => ['+254700123123'],
    'MTN UG' => ['+256780123123'],
]);

it('does not throw exceptions for unsupported networks', function (string $phone): void {
    Saloon::fake([
        SendRequest::class => MockResponse::fixture('sim-swap/unsupported'),
    ]);

    Africastalking::simSwap()
        ->for($phone)
        ->idempotent(fake()->uuid())
        ->send();
})->with([
    'sample 1' => [fake()->e164PhoneNumber()],
    'sample 2' => [fake()->e164PhoneNumber()],
])->throwsNoExceptions();

it('fetches simSwap status for multiple recipients', function (string $phone): void {
    Saloon::fake([
        SendRequest::class => MockResponse::fixture('sim-swap/send-multiple'),
    ]);

    $result = Africastalking::simSwap()
        ->for($phone)
        ->add(phoneNumber: '+254712345678')
        ->send();

    expect($result)
        ->toBeInstanceOf(InsightsResponse::class)
        ->status->toBe(Status::PROCESSED)
        ->cost->currency->toBe(Currency::INTERNATIONAL)
        ->and($result->items)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(2)
        ->each(
            fn(Expectation $transaction) => $transaction->toBeInstanceOf(InsightsResponseItem::class),
        );
})->with([
    'Safaricom Kenya' => ['+254700123123'],
    'MTN UG' => ['+256780123123'],
]);
