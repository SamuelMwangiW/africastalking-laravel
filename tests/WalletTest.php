<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use SamuelMwangiW\Africastalking\Domain\Wallet;
use SamuelMwangiW\Africastalking\Saloon\Requests\Payment\WalletBalanceRequest;
use SamuelMwangiW\Africastalking\ValueObjects\Balance;

it('can be resolved')
    ->expect(
        fn() => app(Wallet::class),
    )->toBeInstanceOf(Wallet::class);

it('can be resolved via helper')
    ->expect(
        fn() => africastalking()->wallet(),
    )->toBeInstanceOf(Wallet::class);

it('can fetch balance', function (): void {
    Saloon::fake([
        WalletBalanceRequest::class => MockResponse::fixture('payments/wallet'),
    ]);

    $balance = app(Wallet::class)->balance();

    expect($balance)
        ->toBeInstanceOf(Balance::class);
});

it('can fetch balance via helper', function (): void {
    Saloon::fake([
        WalletBalanceRequest::class => MockResponse::fixture('payments/wallet'),
    ]);

    $balance = africastalking()->wallet()->balance();

    expect($balance)->toBeInstanceOf(Balance::class);
});

it('throws when failed to fetch balance', function (): void {
    Saloon::fake([
        WalletBalanceRequest::class => MockResponse::fixture('payments/wallet-failed'),
    ]);

    africastalking()->wallet()->balance();
})->throws(Exception::class, 'Failed to fetch wallet balance');
