<?php

use SamuelMwangiW\Africastalking\Facades\Africastalking;

it('can resolve to base class')
    ->expect(fn () => africastalking())
    ->toBeInstanceOf(\SamuelMwangiW\Africastalking\Africastalking::class);
