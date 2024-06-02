<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\ValueObjects\Voice\Action;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\GetDigits;

it('implements the say action')
    ->expect(app(GetDigits::class))->toBeInstanceOf(Action::class);

it('builds to xml')
    ->expect(
        GetDigits::make(
            say: 'Here be dragons',
            finishOnKey: '#',
            timeout: 5,
            numDigits: 10,
            callbackUrl: 'https://example.com/callback',
        )->build(),
    )->toBe(
        '<GetDigits timeout="5" finishOnKey="#" callbackUrl="https://example.com/callback" numDigits="10"><Say>Here be dragons</Say></GetDigits>',
    );

it('can get digits with only the say action message')
    ->expect(
        GetDigits::make('Test message here')->build(),
    )->toBe('<GetDigits><Say>Test message here</Say></GetDigits>');

it('sets the finishOnKey fluently')
    ->expect(
        GetDigits::make('Test message here')
            ->finishOnKey('*')
            ->build(),
    )->toBe('<GetDigits finishOnKey="*"><Say>Test message here</Say></GetDigits>');

it('sets the numDigits fluently')
    ->expect(
        GetDigits::make('Test message here')
            ->numDigits(12)
            ->build(),
    )->toBe('<GetDigits numDigits="12"><Say>Test message here</Say></GetDigits>');

it('sets the timeout fluently')
    ->expect(
        GetDigits::make('Test message here')
            ->timeout(100)
            ->build(),
    )->toBe('<GetDigits timeout="100"><Say>Test message here</Say></GetDigits>');


it('sets the callbackUrl fluently')
    ->expect(
        GetDigits::make('Some Test message here')
            ->callbackUrl('https://test.example.com/callback')
            ->build(),
    )->toBe('<GetDigits callbackUrl="https://test.example.com/callback"><Say>Some Test message here</Say></GetDigits>');
