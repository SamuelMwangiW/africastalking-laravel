<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\Domain\MobileData;

it('can be resolved')
    ->expect(fn () => africastalking()->mobileData())
    ->toBeInstanceOf(MobileData::class);

it('can be resolved via bundles alias')
    ->expect(fn () => africastalking()->bundles())
    ->toBeInstanceOf(MobileData::class);
