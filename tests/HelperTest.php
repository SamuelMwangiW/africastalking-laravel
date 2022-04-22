<?php


it('can resolve to base class')
    ->expect(fn () => africastalking())
    ->toBeInstanceOf(\SamuelMwangiW\Africastalking\Africastalking::class);
