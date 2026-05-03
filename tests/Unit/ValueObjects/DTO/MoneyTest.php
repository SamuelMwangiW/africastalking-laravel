<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\ValueObjects\Money;

test('can be constructed', function (Currency $currency): void {
    $subject = new Money(1000, $currency);

    expect($subject)
        ->toBeInstanceOf(Money::class)
        ->and((string) $subject)->toBe("{$currency->value} 1000")
        ->and((array) $subject)->toBe([
            'amount' => 1000.0,
            'currency' => $currency,
        ]);
})->with(Currency::cases());

test('can be created from a string', function (): void {
    $subject = Money::make('USD 10');

    expect($subject)
        ->toBeInstanceOf(Money::class)
        ->amount->toBe(10.0)
        ->currency->toBe(Currency::INTERNATIONAL);
});
