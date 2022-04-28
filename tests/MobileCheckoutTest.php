<?php

use SamuelMwangiW\Africastalking\Domain\MobileCheckout;

it('resolves the class')
    ->expect(fn() => app(MobileCheckout::class))->toBeInstanceOf(MobileCheckout::class);

it('resolves the class via the helper')
    ->expect(fn() => africastalking()->payment()->mobileCheckout())->toBeInstanceOf(MobileCheckout::class);

it('sends a Mobile Checkout Request', function (string $phone, int $amount) {
    $result = africastalking()
        ->payment()
        ->mobileCheckout()
        ->to($phone)
        ->amount($amount)
        ->currency('KES')
        ->send();

    expect($result)->toBeArray();
})->with('phone-numbers', 'payment-amount');
