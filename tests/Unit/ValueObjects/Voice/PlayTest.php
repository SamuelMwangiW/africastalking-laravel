<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\ValueObjects\Voice\Action;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\Play;

it('implements the say action')
    ->expect(app(Play::class))->toBeInstanceOf(Action::class);

it('builds to xml')
    ->expect(
        Play::make('http://example.com/callback')->build()
    )->toBe('<Play url="http://example.com/callback"/>');

it('updates the url')
    ->expect(
        Play::make('should-be-updated')
            ->url('http://example.com/updated')
            ->build()
    )->toBe('<Play url="http://example.com/updated"/>');
