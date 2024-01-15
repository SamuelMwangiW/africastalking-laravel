<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\Facades\Africastalking;

it('can resolve to base class')
    ->expect(fn() => Africastalking::getFacadeRoot())
    ->toBeInstanceOf(SamuelMwangiW\Africastalking\Africastalking::class);
