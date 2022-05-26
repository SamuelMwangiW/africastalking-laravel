<?php

use SamuelMwangiW\Africastalking\ValueObjects\Voice\Action;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\Say;

it('implements the say action')
    ->expect(app(Say::class))->toBeInstanceOf(Action::class);

it('builds to xml')
    ->expect(
        Say::make(
            message: 'Test say action message',
            playBeep: true,
            voice: 'en-US-Standard-C',
        )->build()
    )->toBe(expected: '<Say voice="en-US-Standard-C" playBeep="true">Test say action message</Say>');

it('sets the playBeep option')
    ->expect(
        Say::make('Test say action message')
            ->playBeep()
            ->build()
    )->toBe(expected: '<Say playBeep="true">Test say action message</Say>');

it('skips the playBeep option when false')
    ->expect(
        Say::make('Test say action message')
            ->playBeep(false)
            ->build()
    )->toBe(expected: '<Say>Test say action message</Say>');

it('sets the voice option')
    ->expect(
        Say::make('Test say action message')
            ->voice('en-US-Standard-C')
            ->build()
    )->toBe(expected: '<Say voice="en-US-Standard-C">Test say action message</Say>');
