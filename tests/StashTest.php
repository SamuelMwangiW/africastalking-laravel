<?php

use SamuelMwangiW\Africastalking\Domain\Stash;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\Enum\Status;
use SamuelMwangiW\Africastalking\ValueObjects\StashTopupResponse;

beforeEach(function () {
    $this->subject = new Stash();
});

it('can be resolved via base class')
    ->expect(fn() => africastalking()->stash())->toBeInstanceOf(Stash::class);

it('can be constructed')->expect(fn() => $this->subject)->toBeInstanceOf(Stash::class);

it('can set amount fluently', function () {
    expect(
        $this->subject->amount(1000)
    )->getAmount()->toBeInt()->toBe(1000);
});

it('can set string currency fluently', function (string $currency) {
    expect(
        $this->subject->currency($currency)
    )->getCurrency()->toBeInstanceOf(Currency::class)
        ->getCurrency()->value->toBe($currency);
})->with('currencies');

it('can set object currency fluently', function (string $currency) {
    expect(
        $this->subject->currency(Currency::from($currency))
    )->getCurrency()->toBeInstanceOf(Currency::class)
        ->getCurrency()->value->toBe($currency);
})->with('currencies');

it('can set metadata fluently', function () {
    expect(
        $this->subject->metadata(['foo' => 'bar'])
    )->getMetadata()->toBe(['foo' => 'bar']);
});

it('can set the productName fluently', function () {
    expect(
        $this->subject->product('fooBarProduct')
    )->getProductName()->toBe('fooBarProduct');
});

it('reads the productName from config', function () {
    config()->set('africastalking.payment.product-name', 'fooBarProduct');

    expect($this->subject)
        ->getProductName()->toBe('fooBarProduct');
});

it('overrides productName values in config', function () {
    config()->set('africastalking.payment.product-name', 'ShouldBeOverriden');

    expect($this->subject->product('fooBarProduct'))
        ->getProductName()->toBe('fooBarProduct');
});

it('can topup stash via send', function () {
    $results = $this->subject->send(currency: 'KES', amount: 100);

    expect($results)
        ->toBeInstanceOf(StashTopupResponse::class)
        ->status->toBeInstanceOf(Status::class);
});

it('can topup stash', function () {
    $results = $this->subject->topup(currency: 'KES', amount: 100);

    expect($results)
        ->toBeInstanceOf(StashTopupResponse::class)
        ->status->toBeInstanceOf(Status::class)
        ->description->toContain('Topped up user stash. New Stash Balance: ');
});
