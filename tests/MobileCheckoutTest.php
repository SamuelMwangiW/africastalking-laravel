<?php

use SamuelMwangiW\Africastalking\Domain\MobileCheckout;
use SamuelMwangiW\Africastalking\Enum\Currency;

it('resolves the class')
    ->expect(fn () => app(MobileCheckout::class))->toBeInstanceOf(MobileCheckout::class);

it('resolves the class via the helper')
    ->expect(fn () => africastalking()->payment()->mobileCheckout())->toBeInstanceOf(MobileCheckout::class);

it('uses the product set in the config', function () {
    $configuredProductName = config('africastalking.payment.product-name');

    $subject = africastalking()
        ->payment()
        ->mobileCheckout();

    expect($subject)
        ->getProductName()->toBe($configuredProductName);
});

it('overrides the product set in the config', function (string $value) {
    $subject = africastalking()
        ->payment()
        ->mobileCheckout()
        ->product($value);

    expect($subject)
        ->getProductName()->toBe($value);
})->with('strings');

it('sets metadata', function (string $value) {
    $metadata = [
        'foo' => $value,
        'bar' => $value,
        'baz' => $value,
    ];

    $subject = africastalking()
        ->payment()
        ->mobileCheckout()
        ->metadata($metadata);

    expect($subject)->getMetadata()->toBe($metadata);
})->with('strings');

it('sends a Mobile Checkout Request', function (string $phone, int $amount) {
    $result = africastalking()
        ->payment()
        ->mobileCheckout()
        ->to($phone)
        ->amount($amount)
        ->currency(currency: Currency::KENYA)
        ->send();

    expect($result)->toBeArray();
})->with('phone-numbers', 'payment-amount');
