<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\ValueObjects\Voice\Action;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\Record;

it('implements the say action')
    ->expect(app(Record::class))->toBeInstanceOf(Action::class);

it('builds to xml')
    ->expect(
        Record::make(
            say: 'Test say action message',
            finishOnKey: '#',
            timeout: 10,
            maxLength: 5,
            playBeep: true,
            trimSilence: true,
            callbackUrl: 'https://example.com/callback.jsp',
        )->build()
    )->toBe(expected: '<Record timeout="10" finishOnKey="#" callbackUrl="https://example.com/callback.jsp" maxLength="5" playBeep="true" trimSilence="true"><Say>Test say action message</Say></Record>');

it('sets the playBeep option')
    ->expect(
        Record::make('Test say action message')
            ->playBeep()
            ->build()
    )->toBe(expected: '<Record playBeep="true"><Say>Test say action message</Say></Record>');

it('skips the playBeep option when false')
    ->expect(
        Record::make('Test say action message')
            ->playBeep(false)
            ->build()
    )->toBe(expected: '<Record><Say>Test say action message</Say></Record>');

it('sets Terminal Recording when no message is passed')
    ->expect(
        Record::make()
            ->playBeep(false)
            ->build()
    )->toBe(expected: '<Record />');

it('sets the finishOnKey option')
    ->expect(
        Record::make('Test say action message')
            ->finishOnKey('#')
            ->build()
    )->toBe(expected: '<Record finishOnKey="#"><Say>Test say action message</Say></Record>');

it('sets the timeout option')
    ->expect(
        Record::make('Test say action message')
            ->timeout(8)
            ->build()
    )->toBe(expected: '<Record timeout="8"><Say>Test say action message</Say></Record>');

it('sets the maxLength option')
    ->expect(
        Record::make('Test say action message')
            ->maxLength(8)
            ->build()
    )->toBe(expected: '<Record maxLength="8"><Say>Test say action message</Say></Record>');

it('sets the trimSilence option')
    ->expect(
        Record::make('Test say action message')
            ->trimSilence()
            ->build()
    )->toBe(expected: '<Record trimSilence="true"><Say>Test say action message</Say></Record>');

it('skips the trimSilence option  when false')
    ->expect(
        Record::make('Test say action message')
            ->trimSilence(false)
            ->build()
    )->toBe(expected: '<Record><Say>Test say action message</Say></Record>');

it('sets the callbackUrl option')
    ->expect(
        Record::make('Test say action message')
            ->callbackUrl('https://example.com/callback')
            ->build()
    )->toBe(expected: '<Record callbackUrl="https://example.com/callback"><Say>Test say action message</Say></Record>');
