<?php

use SamuelMwangiW\Africastalking\Domain\Application;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\ValueObjects\Balance;

it('resolves the application class')
    ->expect(fn () => Africastalking::application())
    ->toBeInstanceOf(Application::class);

it('can fetch the application balance')
    ->expect(fn () => Africastalking::application()->balance())
    ->toBeInstanceOf(Balance::class)
    ->currency->toBeInstanceOf(Currency::class);
