<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\Enum\CallHangupCauses;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\Enum\Direction;
use SamuelMwangiW\Africastalking\Enum\FailureReason;
use SamuelMwangiW\Africastalking\Enum\Network;
use SamuelMwangiW\Africastalking\Enum\PaymentProvider;
use SamuelMwangiW\Africastalking\Enum\Status;
use SamuelMwangiW\Africastalking\Enum\UpdateType;

it('creates FailureReason::class from string', function (string $value): void {
    $enum = FailureReason::tryFrom($value);

    expect($enum)
        ->toBeInstanceOf(FailureReason::class);
})->with('failure-reason-values');

it('creates Network::class from string', function (int $value): void {
    $enum = Network::tryFrom($value);

    expect($enum)
        ->toBeInstanceOf(Network::class)
        ->name()->toBeString()
        ->name()->not->toBeNull();
})->with('network-codes');

it('creates Status::class from string', function (string $value): void {
    $enum = Status::tryFrom($value);

    expect($enum)
        ->toBeInstanceOf(Status::class)
        ->not->toBeNull();
})->with('status-values');

it('creates HangupCause::class from string', function (string $value): void {
    $enum = CallHangupCauses::tryFrom($value);

    expect($enum)
        ->toBeInstanceOf(CallHangupCauses::class)
        ->not->toBeNull();
})->with('hangup-causes');

it('creates CallDirection::class from string', function (string $value): void {
    $enum = Direction::tryFrom($value);

    expect($enum)
        ->toBeInstanceOf(Direction::class)
        ->not->toBeNull();
})->with('call-directions');

it('creates Currency::class from string', function (string $value): void {
    $enum = Currency::tryFrom($value);

    expect($enum)
        ->toBeInstanceOf(Currency::class)
        ->not->toBeNull();
})->with('currencies');

it('creates UpdateType::class from string', function (string $value): void {
    $enum = UpdateType::tryFrom($value);

    expect($enum)
        ->toBeInstanceOf(UpdateType::class)
        ->not->toBeNull();
})->with('update-types');

it('creates PaymentProvider::class from string', function (string $value): void {
    $enum = PaymentProvider::tryFrom($value);

    expect($enum)
        ->toBeInstanceOf(PaymentProvider::class)
        ->not->toBeNull();
})->with('payment-providers');
