<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\ValueObjects\Voice\Action;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\Reject;

it('implements the say action')
    ->expect(app(Reject::class))->toBeInstanceOf(Action::class);

it('builds to xml')
    ->expect(app(Reject::class)->build())->toBe('<Reject/>');
