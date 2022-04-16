<?php

use SamuelMwangiW\Africastalking\Enum\FailureReason;
use SamuelMwangiW\Africastalking\Enum\Network;
use SamuelMwangiW\Africastalking\Enum\Status;

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
