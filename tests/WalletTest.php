<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use SamuelMwangiW\Africastalking\Domain\Wallet;
use SamuelMwangiW\Africastalking\Saloon\Requests\Payment\WalletBalanceRequest;
use SamuelMwangiW\Africastalking\ValueObjects\Balance;

it('can be resolved')
    ->expect(
        fn () => app(Wallet::class)
    )->toBeInstanceOf(Wallet::class);

it('can be resolved via helper')
    ->expect(
        fn () => africastalking()->wallet()
    )->toBeInstanceOf(Wallet::class);

it('can fetch balance')
    ->tap(
        fn () => Saloon::fake([WalletBalanceRequest::class => MockResponse::fixture('payments/wallet')])
    )->expect(
        fn () => app(Wallet::class)->balance()
    )->toBeInstanceOf(Balance::class);

it('can fetch balance via helper')
    ->tap(
        fn () => Saloon::fake([WalletBalanceRequest::class => MockResponse::fixture('payments/wallet')])
    )->expect(
        fn () => africastalking()->wallet()->balance()
    )->toBeInstanceOf(Balance::class);
