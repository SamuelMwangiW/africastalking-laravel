<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\ValueObjects\Voice\Action;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\Dequeue;

it('implements the say action')
    ->expect(fn () => app(Dequeue::class))
    ->toBeInstanceOf(Action::class)
    ->name->toBeNull()
    ->holdMusic->toBeNull();

it('builds to xml')
    ->expect(
        Dequeue::make(
            name: 'pest',
            phoneNumber: '+254722000000',
        )->build()
    )->toBe(
        '<Dequeue name="pest" phoneNumber="+254722000000" />'
    );


it('sets the phone number from config', function (): void {
    config()->set('africastalking.voice.from', '+254733000000');

    expect(
        Dequeue::make()->build()
    )->toBe('<Dequeue phoneNumber="+254733000000" />');
});

it('overrides the queue name passed')
    ->expect(
        fn () => Dequeue::make(name: 'javascript', phoneNumber: '+1234')
            ->queue('php')
            ->build()
    )->toBe('<Dequeue name="php" phoneNumber="+1234" />');
