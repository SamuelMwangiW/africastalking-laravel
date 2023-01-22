<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\Domain\MobileCheckout;
use SamuelMwangiW\Africastalking\Enum\Currency;

it('resolves the class')
    ->expect(fn () => app(MobileCheckout::class))->toBeInstanceOf(MobileCheckout::class);

it('resolves the class via the helper')
    ->expect(fn () => africastalking()->payment()->mobileCheckout())->toBeInstanceOf(MobileCheckout::class);

it('uses the product set in the config', function (): void {
    $configuredProductName = config('africastalking.payment.product-name');

    $subject = africastalking()
        ->payment()
        ->mobileCheckout();

    expect($subject)
        ->getProductName()->toBe($configuredProductName);
});

it('overrides the product set in the config', function (string $value): void {
    $subject = africastalking()
        ->payment()
        ->mobileCheckout()
        ->product($value);

    expect($subject)
        ->getProductName()->toBe($value);
})->with('strings');

it('sets metadata', function (string $value): void {
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

it('sends a Mobile Checkout Request', function (string $phone, int $amount): void {
    $result = africastalking()
        ->payment()
        ->mobileCheckout()
        ->idempotent(fake()->uuid())
        ->to($phone)
        ->amount($amount)
        ->currency(currency: Currency::KENYA)
        ->send();

    if ( ! array_key_exists('providerChannel', $result)) {
        dd($result);
    }

    expect($result)
        ->toBeArray()
        ->toHaveKeys([
            "description",
            "providerChannel",
            "status",
            "transactionId",
        ]);
})->with('phone-numbers', 'payment-amount');
