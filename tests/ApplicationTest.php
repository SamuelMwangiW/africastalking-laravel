<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use SamuelMwangiW\Africastalking\Domain\Application;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\Saloon\Requests\Application\BalanceRequest;
use SamuelMwangiW\Africastalking\ValueObjects\Balance;

it('resolves the application class')
    ->expect(fn () => Africastalking::application())
    ->toBeInstanceOf(Application::class);

it('resolves the application class via alias')
    ->expect(fn () => Africastalking::app())
    ->toBeInstanceOf(Application::class);

it('can fetch the application balance  via application()->balance()', function (): void {
    Saloon::fake([
        BalanceRequest::class => MockResponse::fixture('application/balance')
    ]);

    $balance = Africastalking::application()->balance();

    expect($balance)
        ->toBeInstanceOf(Balance::class)
        ->currency->toBeInstanceOf(Currency::class);
});

it('can fetch the application balance via application()->data()', function (): void {
    Saloon::fake([
        BalanceRequest::class => MockResponse::fixture('application/balance')
    ]);

    $balance = Africastalking::application()->data();

    expect($balance)
        ->toBeInstanceOf(Balance::class)
        ->currency->toBeInstanceOf(Currency::class);
});
