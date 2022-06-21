<?php

use SamuelMwangiW\Africastalking\Domain\Wallet;
use SamuelMwangiW\Africastalking\ValueObjects\Balance;

it('can be resolved')
    ->expect(
        fn() => app(Wallet::class)
    )->toBeInstanceOf(Wallet::class);

it('can be resolved via helper')
    ->expect(
        fn() => africastalking()->wallet()
    )->toBeInstanceOf(Wallet::class);

it('can fetch balance')
    ->expect(
        fn() => app(Wallet::class)->balance()
    )->toBeInstanceOf(Balance::class);

it('can fetch balance via helper')
    ->expect(
        fn() => africastalking()->wallet()->balance()
    )->toBeInstanceOf(Balance::class);
