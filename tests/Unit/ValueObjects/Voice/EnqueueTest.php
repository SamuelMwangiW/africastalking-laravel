<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\ValueObjects\Voice\Action;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\Enqueue;

it('implements the say action')
    ->expect(app(Enqueue::class))
    ->toBeInstanceOf(Action::class)
    ->name->toBeNull()
    ->holdMusic->toBeNull();

it('builds to xml')
    ->expect(
        Enqueue::make(
            name: 'pest',
            holdMusic: 'http://mymediafile.com/playme.mp3',
        )->build()
    )->toBe(
        '<Enqueue name="pest" holdMusic="http://mymediafile.com/playme.mp3" />'
    );


it('sets the queue name')
    ->expect(
        Enqueue::make()
            ->queue('laravel')
            ->build()
    )->toBe('<Enqueue name="laravel" />');

it('overrides the queue name passed')
    ->expect(
        Enqueue::make(name: 'javascript')
            ->queue('php')
            ->build()
    )->toBe('<Enqueue name="php" />');
