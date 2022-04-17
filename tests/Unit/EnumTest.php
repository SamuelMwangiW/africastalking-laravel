<?php

use SamuelMwangiW\Africastalking\Enum\CallDirection;
use SamuelMwangiW\Africastalking\Enum\CallHangupCauses;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\Enum\FailureReason;
use SamuelMwangiW\Africastalking\Enum\Network;
use SamuelMwangiW\Africastalking\Enum\Status;
use SamuelMwangiW\Africastalking\Enum\UpdateType;

it('creates FailureReason::class from string', function (string $value) {
    $enum = FailureReason::tryFrom($value);

    expect($enum)
        ->toBeInstanceOf(FailureReason::class);
})->with('failure-reason-values');

it('creates Network::class from string', function (string $value) {
    $enum = Network::tryFrom($value);

    expect($enum)
        ->toBeInstanceOf(Network::class)
        ->name()->toBeString()
        ->name()->not->toBeNull();
})->with('network-codes');

it('creates Status::class from string', function (string $value) {
    $enum = Status::tryFrom($value);

    expect($enum)
        ->toBeInstanceOf(Status::class)
        ->not->toBeNull();
})->with('status-values');

it('creates HangupCause::class from string', function (string $value) {
    $enum = CallHangupCauses::tryFrom($value);

    expect($enum)
        ->toBeInstanceOf(CallHangupCauses::class)
        ->not->toBeNull();
})->with('hangup-causes');

it('creates CallDirection::class from string', function (string $value) {
    $enum = CallDirection::tryFrom($value);

    expect($enum)
        ->toBeInstanceOf(CallDirection::class)
        ->not->toBeNull();
})->with('call-directions');

it('creates Currency::class from string', function (string $value) {
    $enum = Currency::tryFrom($value);

    expect($enum)
        ->toBeInstanceOf(Currency::class)
        ->not->toBeNull();
})->with('currencies');

it('creates UpdateType::class from string', function (string $value) {
    $enum = UpdateType::tryFrom($value);

    expect($enum)
        ->toBeInstanceOf(UpdateType::class)
        ->not->toBeNull();
})->with('update-types');
