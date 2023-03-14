<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use SamuelMwangiW\Africastalking\Domain\MobileCheckout;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\Saloon\Requests\Payment\MobileCheckoutRequest;
use SamuelMwangiW\Africastalking\ValueObjects\MobileCheckoutResponse;

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

it('sends a Mobile Checkout Request', function (string $phone): void {
    Saloon::fake([
        MobileCheckoutRequest::class => MockResponse::fixture('payments/mobile-checkout')
    ]);

    $amount = random_int(10_000, 70_000);

    $result = africastalking()
        ->payment()
        ->mobileCheckout()
        ->idempotent(fake()->uuid())
        ->to($phone)
        ->amount($amount)
        ->currency(currency: Currency::KENYA)
        ->send();

    expect($result)
        ->toBeInstanceOf(MobileCheckoutResponse::class)
        ->toHaveKeys([
            "description",
            "providerChannel",
            "status",
            "id",
        ]);
})->with('phone-numbers');
