<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\ValueObjects\Voice\Action;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\Redirect;

it('implements the say action')
    ->expect(app(Redirect::class))->toBeInstanceOf(Action::class);

it('builds to xml')
    ->expect(
        Redirect::make('http://example.com/callback')->build(),
    )->toBe('<Redirect>http://example.com/callback</Redirect>');

it('updates the url')
    ->expect(
        Redirect::make('should-be-updated')
            ->url('http://example.com/updated')
            ->build(),
    )->toBe('<Redirect>http://example.com/updated</Redirect>');
