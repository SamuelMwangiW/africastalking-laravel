<?php

declare(strict_types=1);


use SamuelMwangiW\Africastalking\Africastalking;

it('can resolve to base class')
    ->expect(fn() => africastalking())
    ->toBeInstanceOf(Africastalking::class);
