<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Facades;

use Illuminate\Support\Facades\Facade;
use SamuelMwangiW\Africastalking\Africastalking as BaseClass;

/**
 * @see BaseClass
 * @mixin BaseClass
 */
class Africastalking extends Facade
{
    // @todo: implement fake
    protected static function getFacadeAccessor(): string
    {
        return BaseClass::class;
    }
}
