<?php

declare(strict_types=1);

use Illuminate\Support\Facades\App;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Senders\GuzzleSender;
use Saloon\Laravel\Facades\Saloon;
use SamuelMwangiW\Africastalking\Saloon\Requests\Application\BalanceRequest;
use SamuelMwangiW\Africastalking\Saloon\Requests\Payment\WalletBalanceRequest;

it('uses a singleton GuzzleSender', function (): void {
    $bound = App::bound(GuzzleSender::class);

    expect($bound)->toBe(true);
});

it('adds section to about command', function (): void {
    \Saloon\Config::preventStrayRequests();

    Saloon::fake([
        BalanceRequest::class => MockResponse::fixture('application/balance'),
        WalletBalanceRequest::class => MockResponse::fixture('payments/wallet'),
    ]);

    $this
        ->artisan('about')
        ->assertSuccessful()
        ->expectsOutputToContain('USD 999,999,590')
        ->expectsOutputToContain('KES 116,085,350')
        ->doesntExpectOutputToContain('FAILED');
});

it('about command shows FAILED when it is unable to fetch balance', function (): void {
    \Saloon\Config::preventStrayRequests();

    Saloon::fake([]);

    $this
        ->artisan('about')
        ->assertSuccessful()
        ->expectsOutputToContain('FAILED')
        ->doesntExpectOutputToContain('Not setup');
});

it('about command reads africastalking.payment.product-name from config', function (): void {
    \Saloon\Config::preventStrayRequests();
    config()->set('africastalking.payment.product-name', '');

    Saloon::fake([]);

    $this
        ->artisan('about')
        ->assertSuccessful()
        ->expectsOutputToContain('FAILED')
        ->expectsOutputToContain('Not setup');
});
