<?php

use SamuelMwangiW\Africastalking\Facades\Africastalking;

it('can resolve to base class')
    ->expect(fn () => Africastalking::getFacadeRoot())
    ->toBeInstanceOf(\SamuelMwangiW\Africastalking\Africastalking::class);
