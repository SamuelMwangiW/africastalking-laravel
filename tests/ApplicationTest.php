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

it('can fetch the application balance  via application()->balance()')
    ->tap(
        fn () => Saloon::fake([BalanceRequest::class => MockResponse::fixture('application/balance')])
    )->expect(fn () => Africastalking::application()->balance())
    ->toBeInstanceOf(Balance::class)
    ->currency->toBeInstanceOf(Currency::class);

it('can fetch the application balance via application()->data()')
    ->tap(
        fn () => Saloon::fake([BalanceRequest::class => MockResponse::fixture('application/balance')])
    )->expect(fn () => Africastalking::application()->data())
    ->toBeInstanceOf(Balance::class)
    ->currency->toBeInstanceOf(Currency::class);
