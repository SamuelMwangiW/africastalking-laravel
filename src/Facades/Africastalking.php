<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Facades;

use Illuminate\Support\Facades\Facade;
use SamuelMwangiW\Africastalking\Africastalking as BaseClass;
use SamuelMwangiW\Africastalking\Testing\Fakable;
use SamuelMwangiW\Africastalking\Testing\Fakes\AfricastalkingFake;

/**
 * @see BaseClass
 * @mixin BaseClass
 * @mixin AfricastalkingFake
 */
class Africastalking extends Facade
{
    public static function fake(): void
    {
        collect(
            Fakable::cases(),
        )->each(fn(Fakable $fakable) => $fakable->fake());

        static::swap(new AfricastalkingFake());
    }

    protected static function getFacadeAccessor(): string
    {
        return BaseClass::class;
    }
}
